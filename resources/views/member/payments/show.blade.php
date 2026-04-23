@extends('layouts.member')

@section('member-content')
<div class="admin-header">
    <div>
        <h1 class="page-title">Pembayaran Pelatihan</h1>
        <p class="page-subtitle">Invoice {{ $payment->invoice_no }}</p>
    </div>
    <a href="{{ route('member.pelatihan.index') }}" class="btn-outline">← Kembali</a>
</div>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="form-error">{{ session('error') }}</div>
@endif

<div class="payment-grid">
    <!-- CARD INVOICE -->
    <div class="form-card payment-invoice-card">
        <div class="invoice-header">
            <h2 class="invoice-title">INVOICE PEMBAYARAN</h2>
            <p class="invoice-number">No. {{ $payment->invoice_no }}</p>
        </div>

        <div class="form-stack">
            <label>Pelatihan</label>
            <p class="payment-pelatihan">{{ $payment->pelatihan->title }}</p>
        </div>

        <div class="form-stack">
            <label>Nama Member</label>
            <p>{{ auth()->user()->name }}</p>
        </div>

        <div class="form-stack">
            <label>Email</label>
            <p>{{ auth()->user()->email }}</p>
        </div>

        <div class="form-stack">
            <label>Tanggal Invoice</label>
            <p>{{ $payment->created_at->format('d M Y H:i') }}</p>
        </div>

        <div class="payment-amount-section">
            <label>Jumlah Pembayaran</label>
            <p class="payment-amount-large">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
        </div>

        <div class="form-stack">
            <label>Status Pembayaran</label>
            <span class="status-badge status-{{ strtolower($payment->status) }} status-large">
                @if($payment->status === 'pending')
                    ⏳ Menunggu Pembayaran / Review
                @elseif($payment->status === 'paid')
                    ✓ Diterima / Aktif
                @else
                    ✗ Ditolak
                @endif
            </span>
        </div>

        <div class="text-center">
            <button onclick="window.print()" class="btn-outline w-full">🖨️ Cetak Invoice</button>
        </div>
    </div>

    <!-- CARD INSTRUKSI PEMBAYARAN -->
    <div class="form-card payment-instructions-card">
        <div class="section-header">
            <h2>Cara Pembayaran</h2>
            <p>Ikuti langkah-langkah berikut untuk melakukan pembayaran</p>
        </div>

        <div class="payment-method-card">
            <h4>📱 Transfer Bank</h4>
            <div class="bank-details">
                <div class="bank-row">
                    <span>BNI</span>
                    <strong>1472166982</strong>
                </div>
                <div class="bank-row">
                    <span>BCA</span>
                    <strong>2220558692</strong>
                </div>
                <span class="bank-name">a.n Sutriawan</span>
            </div>
        </div>

        <div class="payment-method-card">
            <h4>💳 E-Wallet</h4>
            <div class="bank-details">
                <div class="bank-row">
                    <span>Dana</span>
                    <strong>085225550096</strong>
                </div>
            </div>
        </div>

        <div class="payment-tip-card">
            <p><strong>⚠️ Penting:</strong> Setelah melakukan pembayaran, mohon unggah bukti pembayaran di bawah ini untuk verifikasi.</p>
        </div>
    </div>
</div>

<!-- FORM UNGGAH BUKTI PEMBAYARAN -->
@if($payment->status === 'pending')
    <div class="form-card">
        <h2 style="margin-bottom: 1.5rem;">Unggah Bukti Pembayaran</h2>
        
        <form method="POST" action="{{ route('member.payments.upload-bukti', $payment) }}" enctype="multipart/form-data">
            @csrf

            <div class="form-stack">
                <label for="bukti_path">Pilih File Bukti Pembayaran *</label>
                <input type="file" id="bukti_path" name="bukti_path" accept="image/*,.pdf" class="form-input" required>
                <p style="margin: 0.5rem 0 0 0; color: #666; font-size: 0.9rem;">
                    Format: JPG, PNG, atau PDF (Maksimal 2MB)
                </p>
                @error('bukti_path')
                    <p style="color: #dc3545; margin: 0.5rem 0 0 0;">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-stack">
                <label for="notes">Catatan / Deskripsi (Opsional)</label>
                <textarea id="notes" name="notes" placeholder="Contoh: Pembayaran via BCA Transfer, No. Ref: 123456" class="form-input" rows="3"></textarea>
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn-primary" style="flex: 1;">
                    📤 Unggah Bukti Pembayaran
                </button>
                <a href="{{ route('member.payments.index') }}" class="btn-outline" style="flex: 1; text-align: center; text-decoration: none;">
                    Lihat Daftar Invoice
                </a>
            </div>
        </form>

        <div style="background: #e7f3ff; padding: 1rem; border-radius: 0.5rem; margin-top: 1.5rem; border-left: 4px solid #0066cc;">
            <h4 style="margin: 0 0 0.5rem 0; color: #0066cc;">💡 Tips</h4>
            <ul style="margin: 0; padding-left: 1.5rem; color: #0066cc; font-size: 0.95rem;">
                <li>Pastikan bukti pembayaran jelas dan terlihat informasi transfernya</li>
                <li>Sertakan nama/nomor rekening penyender untuk memudahkan verifikasi</li>
                <li>Admin akan verifikasi dalam 1-2 hari kerja</li>
            </ul>
        </div>
    </div>
@elseif($payment->status === 'paid')
    <div class="form-card" style="background: #d4edda; border: 1px solid #c3e6cb;">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="font-size: 2rem;">✓</div>
            <div>
                <h3 style="margin: 0; color: #155724;">Pembayaran Berhasil</h3>
                <p style="margin: 0.5rem 0 0 0; color: #155724;">Pembayaran telah diterima admin. Pelatihan sudah masuk ke menu Pelatihan Aktif.</p>
            </div>
        </div>
        @if($payment->bukti_path)
            <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #c3e6cb;">
                <a href="{{ route('member.payments.bukti', $payment) }}" target="_blank" class="btn-outline">
                    👁️ Lihat Bukti yang Diunggah
                </a>
            </div>
        @endif
    </div>
@elseif($payment->status === 'rejected')
    <div class="form-card" style="background: #f8d7da; border: 1px solid #f5c6cb;">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <div style="font-size: 2rem; color: #721c24;">✗</div>
            <div>
                <h3 style="margin: 0; color: #721c24;">Pembayaran Ditolak</h3>
                <p style="margin: 0.5rem 0 0 0; color: #721c24;">Pembayaran ditolak oleh admin. Anda dapat mengambil ulang pelatihan ini.</p>
            </div>
        </div>
        <div style="margin-top: 1.5rem;">
            <form method="POST" action="{{ route('member.pelatihan.take', $payment->pelatihan) }}">
                @csrf
                <button type="submit" class="btn-primary" style="width: 100%;">
                    🔄 Ambil Ulang Pelatihan
                </button>
            </form>
        </div>
    </div>
@endif

<style>
    .status-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-weight: bold;
    }
    .status-badge.status-pending {
        background-color: #fff3cd;
        color: #856404;
    }
    .status-badge.status-paid {
        background-color: #d4edda;
        color: #155724;
    }
    .status-badge.status-rejected {
        background-color: #f8d7da;
        color: #721c24;
    }
    
    @media print {
        .admin-header, .form-card:last-child, .btn-outline, nav { 
            display: none !important; 
        }
        .form-card {
            page-break-inside: avoid;
            box-shadow: none !important;
        }
    }
</style>

@endsection
