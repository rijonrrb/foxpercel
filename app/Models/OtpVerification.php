<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpVerification extends Model
{
    protected $table = 'otp_varification';
    use HasFactory;

    protected $fillable = [
        'mobile',
        'email',
        'user_id',
        'otp_date',
        'otp',
        'status',
        'created_at',
        'expire_time',
        'created_by',
        'otp_count',
    ];
}
