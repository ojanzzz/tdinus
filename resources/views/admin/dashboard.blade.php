@extends('layouts.admin')

@section('admin-content')
<div class="admin-header">
    <div>
        <h1 class="page-title">Dashboard Admin</h1>
        <p class="page-subtitle">Ringkasan cepat data situs Anda.</p>
    </div>
    <a href="{{ route('admin.members.index') }}" class="btn-primary">Kelola Member</a>
</div>

<div class="stat-grid">
    <div class="stat-card">
        <h3>Total Layanan</h3>
        <p>{{ $serviceCount ?? 0 }}</p>
    </div>
    <div class="stat-card">
        <h3>Total Berita</h3>
        <p>{{ $newsCount ?? 0 }}</p>
    </div>
    <div class="stat-card">
        <h3>Total Member</h3>
        <p>{{ isset($memberCount) ? $memberCount : '--' }}</p>
    </div>
    <div class="stat-card">
        <h3>Total Pelatihan</h3>
        <p>{{ isset($pelatihanCount) ? $pelatihanCount : '--' }}</p>
    </div>
</div>

<div class="member-card">
    <h2 class="page-title-small">🚀 Akses Cepat</h2>
    <div class="stat-grid">
        <a href="{{ route('admin.news.create') }}" class="stat-card" style="text-decoration: none; cursor: pointer; transition: all 0.3s ease;">
            <h3>📝 Tambah Berita</h3>
            <p style="color: var(--primary-color); font-size: 0.9rem;">Buat berita baru</p>
        </a>
        <a href="{{ route('admin.members.create') }}" class="stat-card" style="text-decoration: none; cursor: pointer; transition: all 0.3s ease;">
            <h3>👤 Tambah Member</h3>
            <p style="color: var(--primary-color); font-size: 0.9rem;">Daftarkan member baru</p>
        </a>
        <a href="{{ route('admin.services.create') }}" class="stat-card" style="text-decoration: none; cursor: pointer; transition: all 0.3s ease;">
            <h3>🛠️ Tambah Layanan</h3>
            <p style="color: var(--primary-color); font-size: 0.9rem;">Tambah layanan baru</p>
        </a>
        <a href="{{ route('admin.sliders.create') }}" class="stat-card" style="text-decoration: none; cursor: pointer; transition: all 0.3s ease;">
            <h3>🖼️ Tambah Slider</h3>
            <p style="color: var(--primary-color); font-size: 0.9rem;">Update slider hero</p>
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

