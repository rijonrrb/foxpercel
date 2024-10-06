<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';

    protected $fillable = [
        'item_category_id',
        'item_name',
        'item_price',
        'currency',
        'item_weight',
        'item_color',
        'item_size',
        'item_model',
        'item_quantity',
        'note',
        'prescription',
    ];

    // Relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'item_category_id');
    }

    // Relationship with Order
    // public function orders()
    // {
    //     return $this->hasMany(Order::class);
    // }
}