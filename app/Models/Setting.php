<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['name', 'value', 'tab', 'type'];

    protected static function booted(): void
    {
        $forgetSettings = fn () => Cache::store('file')->forget('settings');
        static::saved($forgetSettings);
        static::deleted($forgetSettings);
    }

    /**
     * Nilai setting dari cache file, supaya setiap render layout tidak membuka koneksi DB.
     */
    public static function cachedValue(string $name): ?string
    {
        return Cache::store('file')->rememberForever('settings', fn () => static::pluck('value', 'name')->all())[$name] ?? null;
    }
}