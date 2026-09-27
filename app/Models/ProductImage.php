<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    protected $fillable = ['product_id', 'image_path', 'order'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getImageUrlAttribute()
    {
        if (\Str::startsWith($this->image_path, 'gdrive:')) {
            $driveId = str_replace('gdrive:', '', $this->image_path);
            return "https://drive.google.com/uc?export=view&id={$driveId}";
        }
        
        return asset('storage/' . $this->image_path);
    }
}