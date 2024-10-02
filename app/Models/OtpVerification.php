<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpVerification extends Model
{
    protected $table = 'otp_varification';
    use HasFactory;

    protected $fillable = [
        'email',
        'user_id',
        'otp_date',
        'expire_time',
        'otp',
        'otp_count',
        'status',
    ];
}
