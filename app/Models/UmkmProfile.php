<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UmkmProfile extends Model
{
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected $fillable = [
        'user_id',
        'business_name',
        'business_type',
        'type',
        'slug',
        'description',
        'address',
        'kecamatan_id',
        'kelurahan_id',
        'postal_code',
        'phone',
        'whatsapp',
        'logo',
        'banner',
        'status',
        'validated_by',
        'validated_at',
        'rejection_reason',
    ];

    protected $casts = [
        'validated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function validator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function kelurahan(): BelongsTo
    {
        return $this->belongsTo(Kelurahan::class);
    }
}