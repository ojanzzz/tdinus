
@extends('layouts.member')

@section('member-content')
<div class="admin-header">
    <div>
        <h1 class="page-title">Dashboard Member</h1>
        <p class="page-subtitle">Selamat datang kembali, {{ auth()->user()->name ?? 'Member' }}!</p>
    </div>
</div>

<div class="stat-grid">
    <div class="stat-card">
        <h3>Total Sertifikat</h3>
        <p>{{ $sertifikatCount ?? 0 }}</p>
    </div>
    <div class="stat-card">
        <h3>Pelatihan Aktif</h3>
        <p>{{ $activePelatihanCount ?? 0 }}</p>
    </div>
</div>

@if(isset($recentSertifikats) && $recentSertifikats->count())
<div class="member-card">
    <h2 class="page-title-small">Sertifikat Terbaru</h2>
    <div class="stat-grid">
        @foreach($recentSertifikats->take(3) as $sert)
        <div class="stat-card">
            <h3>{{ Str::limit($sert->pelatihan->title, 30) }}</h3>
            <p>{{ $sert->issue_date->format('d M Y') }}</p>
        </div>
        @endforeach
    </div>
</div>
@endif
@endsection
