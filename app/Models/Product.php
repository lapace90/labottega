<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'pricing_type',
        'price_piece',
        'price_per_kg',
        'image_path',
        'is_available',
        'sort_order',
    ];

    protected $casts = [
        'price_piece' => 'decimal:2',
        'price_per_kg' => 'decimal:2',
        'is_available' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class)->orderBy('sort_order');
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_available', true)
            ->whereHas('category', fn ($q) => $q->where('is_active', true));
    }

    public function displayPrice(): string
    {
        if ($this->pricing_type === 'piece') {
            return number_format((float) $this->price_piece, 2, ',', '.') . ' €';
        }

        return number_format((float) $this->price_per_kg, 2, ',', '.') . ' €/kg';
    }

    public function priceForGrams(int $grams): float
    {
        return round((float) $this->price_per_kg * ($grams / 1000), 2);
    }
}
