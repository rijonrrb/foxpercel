<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alarm extends Model
{
    use HasFactory;
    protected $table  = 'alarm';

    protected $fillable = [
        'alarm_level',
        'description',
        'action',
        'user_id',
        'notification_id',
        'order_number'
    ];
    
    public function level()
    {
        return $this->belongsTo(DefconLevel::class, 'alarm_level');
    }

}
