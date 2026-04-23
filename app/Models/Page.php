<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Page extends Model
{
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected $fillable = ['title', 'slug', 'content', 'status', 'created_by', 'meta_title', 'meta_description'];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}