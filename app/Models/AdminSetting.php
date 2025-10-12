<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'setting_name',
        'value',
        'type',
    ];

    public static function get($key, $default = null)
    {
        $setting = self::where('setting_name', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function set($key, $value, $type = 'string')
    {
        return self::updateOrCreate(
            ['setting_name' => $key],
            ['value' => $value, 'type' => $type]
        );
    }
}