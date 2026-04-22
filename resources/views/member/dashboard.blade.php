
@extends('layouts.member')

@section('member-content')
<div class="admin-header">
    <div>
        <h1 class="page-title">📊 Dashboard Member</h1>
        <p class="page-subtitle">Selamat datang kembali, <strong>{{ auth()->user()->name ?? 'Member' }}</strong>!</p>
    </div>
</div>

<div class="stat-grid">
    <div class="stat-card">
        <h3>🏅 Total Sertifikat</h3>
        <p>{{ $sertifikatCount ?? 0 }}</p>
    </div>
    <div class="stat-card">
        <h3>📚 Pelatihan Aktif</h3>
        <p>{{ $activePelatihanCount ?? 0 }}</p>
    </div>
    <div class="stat-card">
        <h3>⏳ Menunggu Konfirmasi</h3>
        <p>{{ isset($pendingSertifikatCount) ? $pendingSertifikatCount : 0 }}</p>
    </div>
</div>

@if(isset($recentSertifikats) && $recentSertifikats->count())
<div class="member-card">
    <h2 class="page-title-small">🎓 Sertifikat Terbaru</h2>
    <div class="stat-grid">
        @foreach($recentSertifikats->take(3) as $sert)
        <div class="stat-card">
            <h3>{{ Str::limit($sert->pelatihan->title, 30) }}</h3>
            <p style="font-size: 0.9rem; color: #666;">{{ $sert->issue_date->format('d M Y') }}</p>
        </div>
        @endforeach
    </div>
</div>
@endif

<div class="member-card">
    <h2 class="page-title-small">🚀 Akses Cepat</h2>
    <div class="stat-grid">
        <a href="/member/pelatihan" class="stat-card" style="text-decoration: none; cursor: pointer; transition: all 0.3s ease;">
            <h3>📚 Lihat Pelatihan</h3>
            <p style="color: var(--primary-color); font-size: 0.9rem;">Jelajahi daftar pelatihan</p>
        </a>
        <a href="/member/profile" class="stat-card" style="text-decoration: none; cursor: pointer; transition: all 0.3s ease;">
            <h3>👤 Edit Profile</h3>
            <p style="color: var(--primary-color); font-size: 0.9rem;">Perbarui data pribadi</p>
        </a>
        <a href="/member/payments" class="stat-card" style="text-decoration: none; cursor: pointer; transition: all 0.3s ease;">
            <h3>💳 Pembayaran</h3>
            <p style="color: var(--primary-color); font-size: 0.9rem;">Lihat riwayat pembayaran</p>
        </a>
        <a href="/member/sertifikat" class="stat-card" style="text-decoration: none; cursor: pointer; transition: all 0.3s ease;">
            <h3>🏅 Sertifikat</h3>
            <p style="color: var(--primary-color); font-size: 0.9rem;">Unduh sertifikat Anda</p>
        </a>
    </div>
</div>

<style>
    .stat-card:hover {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        transform: translateY(-4px);
    }
</style>
@endsection
