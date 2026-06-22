<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['product_id', 'author_name', 'author_email', 'rating', 'comment', 'approved'];

    protected $casts = ['approved' => 'boolean', 'rating' => 'integer'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
