<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name_fr', 'name_en', 'slug', 'image', 'parent_id', 'active', 'sort_order'];

    protected $casts = ['active' => 'boolean'];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getName(): string
    {
        $locale = app()->getLocale();
        return $locale === 'en' ? $this->name_en : $this->name_fr;
    }
}
