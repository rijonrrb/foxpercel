<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use PragmaRX\Google2FA\Google2FA;

class User extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $guarded = [];
    protected $table  = 'users';

    protected $guard = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'otp_verified_at',
        'password',
        'phone',
        'address',
        'image',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Always encrypt password when it is updated.
     *
     * @param $value
     * @return string
     */
    // public function setPasswordAttribute($value)
    // {
    //     $this->attributes['password'] = bcrypt($value);
    // }

    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    public function generateGoogle2FASecret()
    {
        $google2fa = new Google2FA();
        $this->google2fa_secret = $google2fa->generateSecretKey();
        $this->save();
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'user_coupons', 'user_id', 'coupon_id');
    }
}
