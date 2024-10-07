<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';

    protected $fillable = [
        'order_id',
        'item_category_id',
        'item_name',
        'item_price',
        'currency',
        'item_link',
        'item_weight',
        'item_color',
        'item_size',
        'item_quantity',
        'item_model',
        'note',
        'image',
        'prescription'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'item_category_id');
    }

    public function orders()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}