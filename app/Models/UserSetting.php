<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    use HasFactory;
    protected $table  = 'user_settings';

    protected $fillable = [
        'site_name',
        'seo_title',
        'seo_meta_description',
        'seo_keywords',
        'main_motto',
        'user_id',
        'favicon',
        'site_logo',
        'seo_image',
        'alarm_label',
        'table_heading_1',
        'table_heading_2',
        'table_heading_3',
    ];
}
