<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UmkmUserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'kta_number',
        'nik_number',
        'business_actor_name',
        'nib',
        'business_type',
        'business_place_type',
        'business_category',
        'address',
        'kecamatan_id',
        'kelurahan_id',
        'whatsapp',
        'business_products',
        'monthly_turnover',
        'ktp_photo',
        'face_photo',
        'payment_proof'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class);
    }
}
