@extends('layouts.member')

@section('member-content')
<div class="admin-header">
    <div>
        <h1 class="page-title">Invoice {{ $payment->invoice_no }}</h1>
        <p class="page-subtitle">Detail pembayaran pelatihan.</p>
    </div>
</div>

<div class="form-card" style="max-width: 800px; margin: 0 auto;">
    <div style="text-align: center; margin-bottom: 2rem;">
        <h2>INVOICE PEMBAYARAN PELATIHAN</h2>
        <p><strong>No. {{ $payment->invoice_no }}</strong></p>
        <p>Tanggal: {{ $payment->created_at->format('d M Y H:i') }}</p>
    </div>

    <div class="form-stack" style="background: #f8f9fa; padding: 1.5rem; border-radius: 0.5rem;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
            <div>
                <h3>Member</h3>
                <p><strong>{{ auth()->user()->name }}</strong></p>
                <p>{{ auth()->user()->email }}</p>
                @if(auth()->user()->phone)
                    <p>{{ auth()->user()->phone }}</p>
                @endif
            </div>
            <div>
                <h3>Pelatihan</h3>
                <p><strong>{{ $payment->pelatihan->title }}</strong></p>
                @if($payment->pelatihan->duration)
                    <p>Durasi: {{ $payment->pelatihan->duration }}</p>
                @endif
            </div>
        </div>
    </div>

    <div class="form-stack">
        <label>Status Pembayaran</label>
        <span class="status-badge status-{{ strtolower($payment->status) }}" style="font-size: 1.1rem; padding: 0.5rem 1rem;">
            {{ $payment->status === 'pending' ? 'Menunggu Pembayaran' : ucfirst($payment->status) }}
        </span>
        @if($payment->notes)
            <p><strong>Catatan:</strong> {{ $payment->notes }}</p>
        @endif
    </div>

    <div class="form-stack">
        <label>Jumlah Pembayaran</label>
        <p class="form-input" style="font-size: 1.5rem; font-weight: bold; text-align: center; color: #28a745;">
            Rp {{ number_format($payment->amount, 0, ',', '.') }}
        </p>
    </div>

    @if($payment->status === 'pending')
        <div class="form-stack">
            <label>Unggah Bukti Pembayaran</label>
            <form method="POST" action="{{ route('member.payments.upload-bukti', $payment) }}" enctype="multipart/form-data">
                @csrf
                <input type="file" name="bukti_path" accept="image/*,.pdf" class="form-input" required>
                <textarea name="notes" placeholder="Catatan pembayaran (opsional)" class="form-input" rows="3"></textarea>
                <button type="submit" class="btn-primary">Unggah Bukti</button>
            </form>
            <p class="form-hint">Unggah foto transfer/bukti pembayaran. Hubungi admin untuk info rekening.</p>
        </div>
    @endif

    <div class="form-actions" style="justify-content: space-between;">
        <a href="{{ route('member.payments.index') }}" class="btn-outline">← Kembali</a>
        <button onclick="window.print()" class="btn-primary">Cetak Invoice</button>
    </div>
</div>

<style>
    @media print {
        .form-actions, nav, .admin-header { display: none !important; }
        body { margin: 0; }
        .form-card { box-shadow: none; }
    }
</style>
@endsection

