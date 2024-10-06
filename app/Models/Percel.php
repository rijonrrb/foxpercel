<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Percel extends Model
{
    use HasFactory;
    protected $table = 'parcel';

    protected $fillable = [
        'user_id',
        'shopping_from',
        'delivery_country',
        'item_name',
        'item_link',
        'image',
        'category_id',
        'price',
        'currency',
        'weight',
        'color',
        'size',
        'model',
        'quantity',
        'status',
    ];
}
