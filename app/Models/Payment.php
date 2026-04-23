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
        'status',
        'notes',
        'bukti_path',
        'approved_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'approved_at' => 'datetime',
    ];

    protected $appends = ['bukti_url', 'invoice_no'];

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

    public function getInvoiceNoAttribute($value)
    {
        if (!empty($value)) {
            return $value;
        }

        if (!$this->exists) {
            return null;
        }

        $date = $this->created_at?->format('Ymd') ?? now()->format('Ymd');

        return 'INV-' . $date . '-' . str_pad((string) $this->getKey(), 6, '0', STR_PAD_LEFT);
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isPaid()
    {
        return $this->status === 'paid';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }
}
