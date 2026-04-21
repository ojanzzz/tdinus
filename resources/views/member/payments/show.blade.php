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

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
    <!-- CARD INVOICE -->
    <div class="form-card">
        <div style="margin-bottom: 2rem; border-bottom: 2px solid #f0f0f0; padding-bottom: 1rem;">
            <h2 style="margin: 0 0 0.5rem 0;">INVOICE PEMBAYARAN</h2>
            <p style="margin: 0; color: #666; font-size: 0.9rem;">No. {{ $payment->invoice_no }}</p>
        </div>

        <div class="form-stack">
            <label>Pelatihan</label>
            <p style="font-size: 1.2rem; font-weight: bold; margin: 0;">{{ $payment->pelatihan->title }}</p>
        </div>

        <div class="form-stack">
            <label>Nama Member</label>
            <p style="margin: 0;">{{ auth()->user()->name }}</p>
        </div>

        <div class="form-stack">
            <label>Email</label>
            <p style="margin: 0;">{{ auth()->user()->email }}</p>
        </div>

        <div class="form-stack">
            <label>Tanggal Invoice</label>
            <p style="margin: 0;">{{ $payment->created_at->format('d M Y H:i') }}</p>
        </div>

        <div class="form-stack" style="background: #f8f9fa; padding: 1rem; border-radius: 0.5rem;">
            <label style="margin-bottom: 0.5rem;">Jumlah Pembayaran</label>
            <p style="font-size: 1.8rem; font-weight: bold; color: #28a745; margin: 0;">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
        </div>

        <div class="form-stack">
            <label>Status Pembayaran</label>
            <span class="status-badge status-{{ strtolower($payment->status) }}" style="font-size: 1rem;">
                @if($payment->status === 'pending')
                    ⏳ Menunggu Pembayaran
                @elseif($payment->status === 'paid')
                    ✓ Sudah Dibayar
                @else
                    ✗ Ditolak
                @endif
            </span>
        </div>

        <div style="text-align: center;">
            <button onclick="window.print()" class="btn-outline" style="width: 100%;">🖨️ Cetak Invoice</button>
        </div>
    </div>

    <!-- CARD INSTRUKSI PEMBAYARAN -->
    <div class="form-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
        <div style="margin-bottom: 1.5rem;">
            <h2 style="margin: 0 0 0.5rem 0; color: white;">Cara Pembayaran</h2>
            <p style="margin: 0; color: rgba(255,255,255,0.8); font-size: 0.9rem;">Ikuti langkah-langkah berikut untuk melakukan pembayaran</p>
        </div>

        <div style="background: rgba(255,255,255,0.1); padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem;">
            <h4 style="margin: 0 0 0.5rem 0; color: white;">📱 Transfer Bank</h4>
            <p style="margin: 0 0 0.5rem 0; font-size: 0.95rem;">Hubungi admin untuk mendapatkan nomor rekening transfer</p>
            <p style="margin: 0; font-size: 0.9rem; color: rgba(255,255,255,0.8);">Email: <strong>admin@tdinus.com</strong></p>
        </div>

        <div style="background: rgba(255,255,255,0.1); padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem;">
            <h4 style="margin: 0 0 0.5rem 0; color: white;">💳 E-Wallet</h4>
            <p style="margin: 0 0 0.5rem 0; font-size: 0.95rem;">GCash, PayMaya, atau e-wallet lokal lainnya</p>
            <p style="margin: 0; font-size: 0.9rem; color: rgba(255,255,255,0.8);">Hubungi admin untuk detail pembayaran</p>
        </div>

        <div style="background: rgba(255,255,255,0.15); padding: 1rem; border-radius: 0.5rem; border-left: 4px solid #ffd700;">
            <p style="margin: 0; font-size: 0.9rem;">
                <strong>⚠️ Penting:</strong> Setelah melakukan pembayaran, mohon unggah bukti pembayaran di bawah ini untuk verifikasi.
            </p>
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
                <p style="margin: 0.5rem 0 0 0; color: #155724;">Bukti pembayaran telah diverifikasi. Silakan tunggu pemberitahuan lebih lanjut.</p>
            </div>
        </div>
        @if($payment->bukti_path)
            <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #c3e6cb;">
                <a href="{{ Storage::url($payment->bukti_path) }}" target="_blank" class="btn-outline">
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
            <a href="{{ route('member.pelatihan.index') }}" class="btn-primary" style="width: 100%;">
                🔄 Ambil Ulang Pelatihan
            </a>
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
