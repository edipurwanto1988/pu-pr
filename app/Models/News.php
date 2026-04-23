<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class News extends Model
{
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected $fillable = ['title', 'slug', 'content', 'excerpt', 'image', 'status', 'published_at', 'created_by', 'meta_title', 'meta_description'];

    protected $casts = ['published_at' => 'datetime'];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}