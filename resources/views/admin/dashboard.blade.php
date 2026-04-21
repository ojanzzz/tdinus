@extends('layouts.admin')

@section('admin-content')
<div class="admin-header">
    <div>
        <h1 class="page-title">Dashboard Admin</h1>
        <p class="page-subtitle">Ringkasan cepat data situs.</p>
    </div>
    <a href="{{ route('admin.members.index') }}" class="btn-outline">Kelola Member</a>
</div>

<div class="stat-grid">
    <div class="stat-card">
        <h3>Total Layanan</h3>
        <p>{{ $serviceCount }}</p>
    </div>
    <div class="stat-card">
        <h3>Total Berita</h3>
        <p>{{ $newsCount }}</p>
    </div>
</div>
@endsection

