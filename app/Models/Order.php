<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'total_item',
        'shopping_from_country',
        'delivery_country',
        'total_gross_weight',
        'total_dimension_weight',
        'total_amount',
        'shipping_amount',
        'apply_coupon',
        'step',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}