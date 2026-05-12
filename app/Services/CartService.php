<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Collection;

class CartService
{
    protected const SESSION_KEY = 'cart';

    public function getItems(): Collection
    {
        return collect(session(self::SESSION_KEY, []));
    }

    public function count(): int
    {
        return $this->getItems()->sum('quantity');
    }

    public function subtotal(): float
    {
        return $this->getItems()->sum(fn ($item) => $item['line_total']);
    }

    public function isEmpty(): bool
    {
        return $this->getItems()->isEmpty();
    }

    public function hasProduct(int $productId): bool
    {
        return $this->getItems()->contains(fn ($item) => $item['product_id'] === $productId);
    }

    public function productIds(): array
    {
        return $this->getItems()->pluck('product_id')->unique()->values()->all();
    }

    public function add(Product $product, int $quantity, ?int $variantGrams = null): array
    {
        $items = $this->getItems()->keyBy(fn ($i) => $this->itemKey($i['product_id'], $i['variant_grams'] ?? null));

        $key = $this->itemKey($product->id, $variantGrams);

        if ($product->pricing_type === 'weight') {
            if (!$variantGrams) {
                throw new \InvalidArgumentException('Grammatura richiesta per prodotti al peso');
            }
            $unitPrice = $product->priceForGrams($variantGrams);
        } else {
            $unitPrice = (float) $product->price_piece;
        }

        if ($items->has($key)) {
            $existing = $items->get($key);
            $existing['quantity'] += $quantity;
            $existing['line_total'] = $unitPrice * $existing['quantity'];
            $existing['display_quantity'] = $product->pricing_type === 'weight'
                ? "{$variantGrams}g × {$existing['quantity']}"
                : "× {$existing['quantity']}";
            $items->put($key, $existing);
        } else {
            $items->put($key, [
                'product_id'       => $product->id,
                'product_name'     => $product->name,
                'product_slug'     => $product->slug,
                'image_path'       => $product->image_path,
                'pricing_type'     => $product->pricing_type,
                'variant_grams'    => $variantGrams,
                'quantity'         => $quantity,
                'unit_price'       => $unitPrice,
                'line_total'       => $unitPrice * $quantity,
                'display_quantity' => $product->pricing_type === 'weight'
                    ? "{$variantGrams}g × {$quantity}"
                    : "× {$quantity}",
            ]);
        }

        session([self::SESSION_KEY => $items->values()->all()]);

        return [
            'count'      => $this->count(),
            'subtotal'   => $this->subtotal(),
            'item_added' => $items->get($key),
        ];
    }

    public function updateQuantity(int $productId, ?int $variantGrams, int $newQuantity): array
    {
        if ($newQuantity < 1) {
            throw new \InvalidArgumentException('Quantità minima: 1');
        }
        if ($newQuantity > 99) {
            throw new \InvalidArgumentException('Quantità massima: 99');
        }

        $items = $this->getItems();
        $product = \App\Models\Product::find($productId);

        if (!$product) {
            throw new \InvalidArgumentException('Prodotto non trovato');
        }

        $updated = $items->map(function ($item) use ($productId, $variantGrams, $newQuantity, $product) {
            if ($item['product_id'] === $productId && ($item['variant_grams'] ?? null) === $variantGrams) {
                $item['quantity'] = $newQuantity;
                $item['line_total'] = $item['unit_price'] * $newQuantity;
                $item['display_quantity'] = $product->pricing_type === 'weight'
                    ? "{$variantGrams}g × {$newQuantity}"
                    : "× {$newQuantity}";
            }
            return $item;
        });

        session([self::SESSION_KEY => $updated->values()->all()]);

        return [
            'count'    => $this->count(),
            'subtotal' => $this->subtotal(),
            'items'    => $this->getItems()->values()->all(),
        ];
    }

    public function removeItem(int $productId, ?int $variantGrams = null): array
    {
        $this->remove($productId, $variantGrams);

        return [
            'count'    => $this->count(),
            'subtotal' => $this->subtotal(),
            'items'    => $this->getItems()->values()->all(),
            'is_empty' => $this->isEmpty(),
        ];
    }

    public function remove(int $productId, ?int $variantGrams = null): void
    {
        $items = $this->getItems()->reject(
            fn ($item) => $item['product_id'] === $productId
                && ($item['variant_grams'] ?? null) === $variantGrams
        );
        session([self::SESSION_KEY => $items->values()->all()]);
    }

    public function clear(): void
    {
        session()->forget(self::SESSION_KEY);
    }

    protected function itemKey(int $productId, ?int $variantGrams): string
    {
        return $variantGrams ? "{$productId}-{$variantGrams}" : (string) $productId;
    }
}
