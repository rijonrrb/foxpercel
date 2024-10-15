<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $table = 'coupons';

    protected $fillable = [
        'name',
        'coupon_code',
        'coupon_type',
        'amount',
        'order_min_value',
        'validity_from',
        'validity_to',
        'usability',
        'status',
    ];
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_coupons')->withPivot('user_id');
    }
}
