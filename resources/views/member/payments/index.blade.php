@extends('layouts.member')

@section('member-content')
<div class="admin-header">
    <div>
        <h1 class="page-title">Pembayaran Pelatihan</h1>
        <p class="page-subtitle">Daftar invoice pembayaran pelatihan Anda.</p>
    </div>
    <a href="{{ route('member.dashboard') }}" class="btn-outline">← Dashboard</a>
</div>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="form-error">{{ session('error') }}</div>
@endif

@if($payments->isNotEmpty())
    <div class="responsive-payments">
        @foreach($payments as $payment)
            <div class="payment-card form-card">
                <div class="payment-header">
                    <div>
                        <strong>{{ $payment->invoice_no }}</strong>
                        <span class="status-badge status-{{ strtolower($payment->status) }}">
                            {{ $payment->status === 'pending' ? 'Menunggu Pembayaran' : ucfirst($payment->status) }}
                        </span>
                    </div>
                    <div class="payment-date">{{ $payment->created_at->format('d M Y') }}</div>
                </div>
                <h3 class="payment-title">{{ $payment->pelatihan->title }}</h3>
                <div class="payment-amount">Rp {{ number_format($payment->amount, 0, ',', '.') }}</div>
                @if($payment->bukti_path)
                    <a href="{{ Storage::url($payment->bukti_path) }}" target="_blank" class="btn-outline small mt-2">Lihat Bukti</a>
                @endif
                <div class="payment-actions">
                    @if($payment->status === 'rejected')
                        <a href="{{ route('member.pelatihan.index') }}" class="btn-primary w-full">Ambil Ulang Pelatihan</a>
                    @else
                        <a href="{{ route('member.payments.show', $payment) }}" class="btn-primary w-full">Lihat Invoice</a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    <div class="pagination-wrap mt-4">
        {{ $payments->links() }}
    </div>
@else
    <div class="admin-main-empty">
        <p>Belum ada pembayaran pelatihan.</p>
        <a href="{{ route('member.pelatihan.index') }}" class="btn-primary">Lihat Pelatihan</a>
    </div>
@endif
@endsection

