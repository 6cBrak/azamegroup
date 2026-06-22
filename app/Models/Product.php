<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name_fr', 'name_en', 'slug',
        'description_fr', 'description_en', 'price', 'stock',
        'images', 'active', 'featured',
    ];

    protected $casts = [
        'images' => 'array',
        'active' => 'boolean',
        'featured' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(Review::class)->where('approved', true)->latest();
    }

    public function getName(): string
    {
        $locale = app()->getLocale();
        return $locale === 'en' ? $this->name_en : $this->name_fr;
    }

    public function getDescription(): string
    {
        $locale = app()->getLocale();
        return $locale === 'en' ? ($this->description_en ?? '') : ($this->description_fr ?? '');
    }

    public function getFirstImage(): ?string
    {
        if ($this->images && count($this->images) > 0) {
            return $this->images[0];
        }
        return null;
    }

    public function isInStock(): bool
    {
        return $this->stock > 0;
    }
}
