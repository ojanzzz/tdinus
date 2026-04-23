@extends('layouts.member')

@section('member-content')
<div class="admin-header">
    <div>
        <h1 class="page-title">💳 Pembayaran Pelatihan</h1>
        <p class="page-subtitle">Kelola invoice dan status pembayaran pelatihan Anda.</p>
    </div>
    <a href="{{ route('member.dashboard') }}" class="btn-outline">← Kembali</a>
</div>

@if(session('success'))
    <div class="alert-success">✓ {{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert-danger">⚠️ {{ session('error') }}</div>
@endif

@if($payments->isNotEmpty())
    <div style="display: grid; gap: 1.5rem;">
        @foreach($payments as $payment)
            <div class="member-card" style="padding: 2rem; border-left: 4px solid var(--primary-color);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
                    <div>
                        <div style="font-weight: 600; color: #666; font-size: 0.9rem;">Invoice No.</div>
                        <div style="font-size: 1.1rem; font-weight: 700; color: var(--dark-color);">{{ $payment->invoice_no }}</div>
                    </div>
                    <div style="text-align: right;">
                        <span class="status-badge status-{{ strtolower($payment->status) }}" style="font-size: 0.9rem;">
                            @if($payment->status === 'pending')
                                ⏳ Menunggu Pembayaran / Review
                            @elseif($payment->status === 'paid')
                                ✓ Diterima / Aktif
                            @elseif($payment->status === 'rejected')
                                ❌ Ditolak
                            @else
                                {{ ucfirst($payment->status) }}
                            @endif
                        </span>
                        <div style="font-size: 0.9rem; color: #999; margin-top: 0.5rem;">{{ $payment->created_at->format('d M Y H:i') }}</div>
                    </div>
                </div>

                <div style="background: var(--light-color); padding: 1.5rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                    <div style="margin-bottom: 1rem;">
                        <div style="font-weight: 600; color: #666; font-size: 0.9rem; margin-bottom: 0.5rem;">Pelatihan</div>
                        <div style="font-size: 1.1rem; font-weight: 600; color: var(--dark-color);">{{ $payment->pelatihan->title }}</div>
                    </div>
                    
                    <div style="padding-top: 1rem; border-top: 1px solid var(--border-color);">
                        <div style="font-weight: 600; color: #666; font-size: 0.9rem; margin-bottom: 0.5rem;">Total Pembayaran</div>
                        <div style="font-size: 1.5rem; font-weight: 700; color: var(--primary-color);">Rp {{ number_format($payment->amount, 0, ',', '.') }}</div>
                    </div>
                </div>

                @if($payment->notes)
                    <div style="background: rgba(245, 158, 11, 0.1); padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem; border-left: 3px solid var(--warning-color);">
                        <small style="color: #666;">Catatan:</small>
                        <p style="margin: 0.5rem 0 0 0; color: #333;">{{ $payment->notes }}</p>
                    </div>
                @endif

                @if($payment->bukti_path)
                    <div style="margin-bottom: 1rem;">
                        <a href="{{ Storage::url($payment->bukti_path) }}" target="_blank" class="btn-outline" style="padding: 0.75rem 1.5rem;">
                            📎 Lihat Bukti Pembayaran
                        </a>
                    </div>
                @endif

                <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                    @if($payment->status === 'rejected')
                        <form method="POST" action="{{ route('member.pelatihan.take', $payment->pelatihan) }}" style="flex: 1; min-width: 200px;">
                            @csrf
                            <button type="submit" class="btn-primary" style="width: 100%; text-align: center; padding: 0.75rem;">
                                Ambil Ulang Pelatihan
                            </button>
                        </form>
                    @else
                        <a href="{{ route('member.payments.show', $payment) }}" class="btn-primary" style="flex: 1; min-width: 200px; text-align: center; padding: 0.75rem;">
                            Lihat Detail Invoice
                        </a>
                    @endif
                    @if($payment->status === 'pending')
                        <a href="{{ route('member.payments.show', $payment) }}" class="btn-outline" style="flex: 1; min-width: 200px; text-align: center; padding: 0.75rem;">
                            Upload / Ganti Bukti
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    @if($payments->hasPages())
        <div style="margin-top: 2rem; display: flex; justify-content: center;">
            {{ $payments->links() }}
        </div>
    @endif
@else
    <div class="member-card" style="text-align: center; padding: 3rem 1.5rem;">
        <p style="font-size: 1.2rem; color: #999; margin: 0;">💳 Belum Ada Pembayaran</p>
        <p style="color: #999; margin-top: 0.5rem;">Ambil pelatihan untuk membuat invoice pembayaran.</p>
        <a href="{{ route('member.pelatihan.index') }}" class="btn-primary" style="display: inline-block; margin-top: 1rem; padding: 0.75rem 1.5rem;">
            Lihat Pelatihan Tersedia
        </a>
    </div>
@endif
@endsection
