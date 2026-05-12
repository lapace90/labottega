<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(protected CartService $cart) {}

    public function add(Request $request): JsonResponse
    {
        $data = $request->validate([
            'product_id'   => 'required|integer|exists:products,id',
            'quantity'     => 'required|integer|min:1|max:99',
            'variant_grams' => 'nullable|integer|min:1',
        ]);

        $product = Product::available()->findOrFail($data['product_id']);

        try {
            $result = $this->cart->add(
                $product,
                $data['quantity'],
                $data['variant_grams'] ?? null
            );
        } catch (\InvalidArgumentException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }

        return response()->json([
            'success'       => true,
            'cart_count'    => $result['count'],
            'cart_subtotal' => $result['subtotal'],
            'item_added'    => $result['item_added'],
        ]);
    }

    public function summary(): JsonResponse
    {
        return response()->json([
            'count'       => $this->cart->count(),
            'subtotal'    => $this->cart->subtotal(),
            'product_ids' => $this->cart->productIds(),
            'is_empty'    => $this->cart->isEmpty(),
        ]);
    }
}
