<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = ['title', 'subtitle', 'image', 'link', 'button_text', 'order', 'status'];
}