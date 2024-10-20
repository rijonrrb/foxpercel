<?php

namespace App\Models;

use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Currency extends Model
{
    use HasFactory;
    protected $table = 'currencies';
    
    protected $fillable = [
        'name',
        'code',
        'symbol',
        'status'
    ];

}
