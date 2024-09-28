<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefconLevel extends Model
{
    use HasFactory;
    protected $table  = 'defcon_level';

    protected $fillable = [
        'defcon_level',
        'color',
        'is_default',
        'user_id',
        'order_number'
    ];
}
