<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $table = 'site_settings';
    protected $fillable = ['key', 'value'];

    public static function get($key, $default = null)
    {
        try {
            $setting = static::where('key', $key)->first();
            return ($setting && !is_null($setting->value) && $setting->value !== '') ? $setting->value : $default;
        } catch (\Exception $e) {
            return $default;
        }
    }

    public static function set($key, $value)
    {
        return static::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
