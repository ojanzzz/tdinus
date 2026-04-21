<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'pelatihan_id', 
        'amount',
        'invoice_no',
        'status',
        'notes',
        'bukti_path'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    protected $appends = ['bukti_url'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pelatihan()
    {
        return $this->belongsTo(Pelatihan::class);
    }

    public function getBuktiUrlAttribute()
    {
        return $this->bukti_path ? Storage::url($this->bukti_path) : null;
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isPaid()
    {
        return $this->status === 'paid';
    }
}

