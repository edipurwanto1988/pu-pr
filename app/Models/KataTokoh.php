<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KataTokoh extends Model
{
    protected $fillable = ['nama', 'jabatan', 'deskripsi', 'foto', 'order', 'status'];
}