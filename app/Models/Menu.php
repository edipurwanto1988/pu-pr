<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Menu extends Model
{
    protected $fillable = ['parent_id', 'title', 'url', 'icon', 'target', 'order', 'status'];

    protected static function booted(): void
    {
        $forgetFrontendMenus = fn () => Cache::store('file')->forget('frontend_menus');
        static::saved($forgetFrontendMenus);
        static::deleted($forgetFrontendMenus);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }
}