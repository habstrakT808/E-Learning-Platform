<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'group',
        'display_name',
        'description',
        'type',
        'options',
        'is_public'
    ];

    protected $casts = [
        'options' => 'array',
        'is_public' => 'boolean'
    ];

    /**
     * Get a setting value by key
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        $setting = Cache::rememberForever('platform_settings', function () {
            return self::pluck('value', 'key')->all();
        });

        return $setting[$key] ?? $default;
    }

    /**
     * Set a setting value
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public static function set($key, $value)
    {
        self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        Cache::forget('platform_settings');
        return true;
    }

    /**
     * Get all settings in a specific group
     *
     * @param string $group
     * @return \Illuminate\Support\Collection
     */
    public static function getGroup($group)
    {
        return self::where('group', $group)->get();
    }

    /**
     * Get all public settings
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getPublicSettings()
    {
        return self::where('is_public', true)->get();
    }

    /**
     * Get all settings in a specific group
     *
     * @param string $group
     * @return \Illuminate\Support\Collection
     */
    public static function group(string $group)
    {
        return self::where('group', $group)->get()->mapWithKeys(function ($setting) {
            return [$setting->key => self::formatValue($setting)];
        });
    }

    /**
     * Format the setting value based on its type
     *
     * @param Setting $setting
     * @return mixed
     */
    private static function formatValue(Setting $setting)
    {
        $value = $setting->value;

        switch ($setting->type) {
            case 'boolean':
                return (bool) $value;
            case 'number':
                return (float) $value;
            case 'array':
            case 'json':
                return json_decode($value, true) ?: [];
            default:
                return $value;
        }
    }
}
