<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelatihan extends Model
{
    protected $fillable = [
        'title', 
        'slug', 
        'description', 
        'image_path', 
        'duration', 
        'price', 
        'status'
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function sertifikats()
    {
        return $this->hasMany(Sertifikat::class);
    }
}
