@extends('layouts.app')

@section('content')
<div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow-lg">
        <div class="card-body p-5">
            <!-- Header -->
            <div style="text-align: center; margin-bottom: 2rem;">
                <h1 style="color: #1181b3; margin-bottom: 0.5rem;">Konfirmasi Ambil Pelatihan</h1>
                <p style="color: #666; margin: 0;">Periksa detail pelatihan sebelum melanjutkan</p>
            </div>

            <!-- Detail Pelatihan -->
            <div style="background: #f8f9fa; padding: 1.5rem; border-radius: 0.5rem; margin-bottom: 2rem;">
                <h3 style="margin-bottom: 1rem; color: #333;">{{ $pelatihan->title }}</h3>
                <p style="color: #666; line-height: 1.6; margin: 0;">{{ $pelatihan->description }}</p>
                
                @if($pelatihan->duration)
                    <div style="margin-top: 1rem;">
                        <strong style="color: #333;">Durasi:</strong>
                        <span style="color: #666;">{{ $pelatihan->duration }} jam</span>
                    </div>
                @endif
            </div>

            <!-- Info Harga -->
            <div style="border: 2px solid #1181b3; padding: 1.5rem; border-radius: 0.5rem; margin-bottom: 2rem; text-align: center;">
                <p style="margin: 0 0 0.5rem 0; color: #666; font-size: 0.95rem;">Harga Pelatihan</p>
                @if($pelatihan->price > 0)
                    <h2 style="margin: 0; color: #1181b3; font-size: 2.5rem;">Rp {{ number_format($pelatihan->price, 0, ',', '.') }}</h2>
                    <p style="margin: 0.5rem 0 0 0; color: #666; font-size: 0.9rem;">Pembayaran diperlukan untuk melanjutkan</p>
                @else
                    <h2 style="margin: 0; color: #28a745; font-size: 2.5rem;">GRATIS</h2>
                    <p style="margin: 0.5rem 0 0 0; color: #666; font-size: 0.9rem;">Pelatihan ini tersedia tanpa biaya</p>
                @endif
            </div>

            <!-- Info Proses -->
            <div style="background: #e7f3ff; padding: 1rem; border-radius: 0.5rem; margin-bottom: 2rem; border-left: 4px solid #1181b3;">
                @if($pelatihan->price > 0)
                    <h5 style="margin: 0 0 0.5rem 0; color: #1181b3;">📋 Proses Pembayaran:</h5>
                    <ol style="margin: 0; padding-left: 1.5rem; color: #333;">
                        <li>Lanjutkan ke halaman pembayaran</li>
                        <li>Lakukan transfer sesuai nominal yang tertera</li>
                        <li>Unggah bukti pembayaran</li>
                        <li>Tunggu verifikasi dari admin (1-2 hari kerja)</li>
                        <li>Mulai mengerjakan pelatihan setelah verifikasi</li>
                    </ol>
                @else
                    <h5 style="margin: 0 0 0.5rem 0; color: #1181b3;">✓ Pelatihan Gratis</h5>
                    <p style="margin: 0; color: #333;">Klik tombol "Ambil Pelatihan" untuk langsung memulai pelatihan ini.</p>
                @endif
            </div>

            <!-- Form Actions -->
            <div style="display: flex; gap: 1rem;">
                <a href="/pelatihan/{{ $pelatihan->slug }}" class="btn btn-outline" style="flex: 1; padding: 0.75rem; text-align: center; text-decoration: none; border: 2px solid #ccc; color: #333; border-radius: 0.5rem; cursor: pointer;">
                    ← Batal
                </a>
                <form action="{{ route('member.pelatihan.take', $pelatihan->id) }}" method="POST" style="flex: 1;">
                    @csrf
                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.75rem; background: #1181b3; color: white; border: none; border-radius: 0.5rem; cursor: pointer; font-weight: bold;">
                        @if($pelatihan->price > 0)
                            Lanjut ke Pembayaran →
                        @else
                            Ambil Pelatihan Sekarang →
                        @endif
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-outline:hover {
        background: #f0f0f0;
    }
    
    .btn-primary:hover {
        background: #0f5ba8 !important;
    }
</style>

@endsection
