<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sertifikat extends Model
{
    protected $fillable = [
        'user_id',
        'pelatihan_id', 
        'issue_date',
        'expiry_date',
        'file_path',
        'status'
    ];

    protected $casts = [
        'issue_date' => 'date',
        'expiry_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pelatihan()
    {
        return $this->belongsTo(Pelatihan::class);
    }
}
