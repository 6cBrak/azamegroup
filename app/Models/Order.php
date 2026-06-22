<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'reference', 'customer_id', 'customer_name', 'customer_phone', 'customer_email',
        'customer_city', 'customer_address', 'notes', 'total', 'status',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending'   => __('orders.status.pending'),
            'confirmed' => __('orders.status.confirmed'),
            'shipped'   => __('orders.status.shipped'),
            'delivered' => __('orders.status.delivered'),
            'cancelled' => __('orders.status.cancelled'),
            default     => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending'   => 'yellow',
            'confirmed' => 'blue',
            'shipped'   => 'purple',
            'delivered' => 'green',
            'cancelled' => 'red',
            default     => 'gray',
        };
    }

    public static function generateReference(): string
    {
        return 'CMD-' . strtoupper(uniqid());
    }
}
