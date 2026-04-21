@extends('layouts.member')

@section('member-content')
<div class="admin-header">
    <div>
        <h1 class="page-title">Pelatihan</h1>
        <p class="page-subtitle">Pilih pelatihan aktif. Setelah ambil, admin akan melihat progress dan menerbitkan sertifikat.</p>
    </div>
    <div style="display: flex; gap: 1rem;">
        <a href="{{ route('member.payments.index') }}" class="btn-primary">Pembayaran</a>
        <a href="{{ route('member.dashboard') }}" class="btn-outline">← Dashboard</a>
    </div>
</div>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="form-error">{{ session('error') }}</div>
@endif

@if($available->isNotEmpty())
    <div class="member-card">
        <h2 class="page-title-small">Pelatihan Tersedia</h2>
        <div class="hero-grid">
            @foreach($available as $p)
                <div class="hero-card">
                    @if($p->image_path)
                        <img src="{{ $p->image_path }}" alt="{{ $p->title }}" class="thumb-image">
                    @endif
                    <h3>{{ $p->title }}</h3>
                    <p>{{ Str::limit($p->description, 100) }}</p>
                    @if($p->duration || $p->price)
                        <p><strong>{{ $p->duration }}</strong> | @if($p->price > 0) Rp {{ number_format($p->price ?? 0, 0, ',', '.') }} @else Gratis @endif</p>
                    @endif
                    <form method="POST" action="{{ route('member.pelatihan.take', $p) }}">
                        @csrf
                        <button type="submit" class="btn-primary">Ambil Pelatihan</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
@else
    <div class="admin-main-empty">
        <p>Tidak ada pelatihan aktif saat ini.</p>
    </div>
@endif

@if($completed->isNotEmpty())
    <div class="member-card">
        <h2 class="page-title-small">Pelatihan yang Diambil</h2>
        <div class="table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Pelatihan</th>
                        <th>Tanggal Ambil</th>
                        <th>Pembayaran</th>
                        <th>Status Sertifikat</th>
                        <th>Sertifikat</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($completed as $item)
                        <tr>
                            <td>{{ $item->pelatihan->title ?? '-' }}</td>
                            <td>{{ $item->issue_date?->format('d M Y') ?? '-' }}</td>
                            @if($item->payment)
                                <span class="status-badge status-{{ strtolower($item->payment->status) }}">{{ ucfirst($item->payment->status) }}</span>
                                @if($item->payment->status === 'pending')
                                    <br><small>Awaiting admin</small>
                                @elseif($item->payment->status === 'paid')
                                    <br><small><i class="fas fa-check text-success"></i> Terbayar</small>
                                @endif
                            @else
                                <span class="text-muted">-</span>
                            @endif
                            <td>
                                <span class="status-badge status-{{ strtolower($item->status) }}">
                                    @if($item->status === 'pending')
                                        Menunggu Konfirmasi
                                    @elseif($item->status === 'in_progress')
                                        Terkonfirmasi
                                    @else
                                        {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                                    @endif
                                </span>
                            </td>
                            <td>
                                @if($item->status === 'issued' && $item->file_path)
                                    <a href="{{ $item->file_path }}" target="_blank" class="btn-primary">Download</a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
@endsection

