<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'order_number',
        'user_id',
        'total_item',
        'shopping_from_country',
        'delivery_country',
        'delivery_address',
        'total_gross_weight',
        'total_dimension_weight',
        'total_amount',
        'shipping_amount',
        'apply_coupon',
        'step',
        'status',
        'payment_status',
        'tracking_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}