@extends('layouts.member')

@section('member-content')
<div class="admin-header">
    <div>
        <h1 class="page-title">📚 Pelatihan Tersedia</h1>
        <p class="page-subtitle">Pilih pelatihan aktif untuk mulai belajar. Admin akan melihat progress Anda.</p>
    </div>
    <a href="{{ route('member.dashboard') }}" class="btn-outline">← Kembali</a>
</div>

@if(session('success'))
    <div class="alert-success">✓ {{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert-danger">⚠️ {{ session('error') }}</div>
@endif

@if($available->isNotEmpty())
    <div class="member-card">
        <h2 class="page-title-small">🎓 Pelatihan Aktif</h2>
        <p style="color: #666; margin-bottom: 1.5rem;">Pilih pelatihan di bawah untuk memulai pembelajaran Anda.</p>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
            @foreach($available as $p)
                <div style="background: white; border-radius: 0.75rem; overflow: hidden; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08); transition: all 0.3s ease; border-left: 4px solid var(--primary-color);">
                    @if($p->image_path)
                        <img src="{{ $p->image_path }}" alt="{{ $p->title }}" style="width: 100%; height: 200px; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 200px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); display: flex; align-items: center; justify-content: center; color: white;">
                            📚 {{ substr($p->title, 0, 1) }}
                        </div>
                    @endif
                    <div style="padding: 1.5rem;">
                        <h3 style="margin: 0 0 0.75rem 0; font-size: 1.1rem; color: var(--dark-color);">{{ Str::limit($p->title, 35) }}</h3>
                        <p style="margin: 0 0 1rem 0; color: #666; font-size: 0.9rem; line-height: 1.5;">{{ Str::limit($p->description, 80) }}</p>
                        
                        <div style="display: flex; gap: 1rem; margin: 1rem 0; padding: 1rem 0; border-top: 1px solid var(--border-color); border-bottom: 1px solid var(--border-color);">
                            @if($p->duration)
                                <div style="flex: 1; text-align: center;">
                                    <small style="color: #999;">Durasi</small>
                                    <p style="margin: 0.5rem 0 0 0; font-weight: 600; color: var(--primary-color);">{{ $p->duration }}</p>
                                </div>
                            @endif
                            @if($p->price)
                                <div style="flex: 1; text-align: center;">
                                    <small style="color: #999;">Harga</small>
                                    <p style="margin: 0.5rem 0 0 0; font-weight: 600; color: var(--primary-color);">
                                        @if($p->price > 0)
                                            Rp {{ number_format($p->price, 0, ',', '.') }}
                                        @else
                                            Gratis
                                        @endif
                                    </p>
                                </div>
                            @endif
                        </div>
                        
                        <form method="POST" action="{{ route('member.pelatihan.take', $p) }}" style="display: block; width: 100%;">
                            @csrf
                            <button type="submit" class="btn-primary" style="width: 100%; text-align: center; padding: 0.75rem;">Ambil Pelatihan</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@else
    <div class="member-card" style="text-align: center; padding: 3rem 1.5rem;">
        <p style="font-size: 1.2rem; color: #999; margin: 0;">📚 Tidak ada pelatihan aktif saat ini.</p>
        <p style="color: #999; margin-top: 0.5rem;">Silakan cek kembali nanti atau hubungi admin.</p>
    </div>
@endif

@if($completed->isNotEmpty())
    <div class="member-card">
        <h2 class="page-title-small">✓ Pelatihan Diambil</h2>
        <p style="color: #666; margin-bottom: 1.5rem;">Riwayat pelatihan yang telah Anda daftar dan status sertifikatnya.</p>
        <div class="table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Pelatihan</th>
                        <th>Tanggal Ambil</th>
                        <th>Status</th>
                        <th>Sertifikat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($completed as $item)
                        <tr>
                            <td>
                                <strong>{{ Str::limit($item->pelatihan->title ?? '-', 40) }}</strong>
                            </td>
                            <td>
                                <small>{{ $item->issue_date?->format('d M Y') ?? '-' }}</small>
                            </td>
                            <td>
                                <span class="status-badge status-{{ strtolower($item->status) }}">
                                    @if($item->status === 'pending')
                                        ⏳ Menunggu
                                    @elseif($item->status === 'in_progress')
                                        ▶️ Berlangsung
                                    @elseif($item->status === 'issued')
                                        ✓ Selesai
                                    @else
                                        {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                                    @endif
                                </span>
                            </td>
                            <td>
                                @if($item->status === 'issued' && $item->file_path)
                                    <a href="{{ $item->file_path }}" target="_blank" class="btn-outline" style="padding: 0.5rem 1rem; font-size: 0.85rem;">📥 Download</a>
                                @else
                                    <span style="color: #999;">-</span>
                                @endif
                            </td>
                            <td>
                                @if($item->payment)
                                    <span class="status-badge status-{{ strtolower($item->payment->status) }}" style="font-size: 0.8rem;">
                                        @if($item->payment->status === 'pending')
                                            ⏳ Menunggu
                                        @elseif($item->payment->status === 'paid')
                                            ✓ Terbayar
                                        @else
                                            {{ ucfirst($item->payment->status) }}
                                        @endif
                                    </span>
                                @else
                                    <span style="color: #999;">-</span>
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

