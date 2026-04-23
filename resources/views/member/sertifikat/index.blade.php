@extends('layouts.member')

@section('member-content')
<div class="admin-header">
    <div>
        <h1 class="page-title">🏅 Sertifikat Saya</h1>
        <p class="page-subtitle">Daftar sertifikat yang telah Anda terima dari pelatihan.</p>
    </div>
    <a href="/member/pelatihan" class="btn-outline">← Lihat Pelatihan</a>
</div>

@if($sertifikats->isEmpty())
    <div class="member-card" style="text-align: center; padding: 3rem 1.5rem;">
        <h2 style="color: #999; margin: 0 0 1rem 0;">📋 Belum Ada Sertifikat</h2>
        <p style="color: #999; margin: 0 0 1.5rem 0;">Ikuti pelatihan untuk mendapatkan sertifikat setelah menyelesaikan program.</p>
        <a href="/member/pelatihan" class="btn-primary">Lihat Pelatihan Tersedia</a>
    </div>
@else
    <div class="member-card">
        <h2 class="page-title-small">Sertifikat Anda</h2>
        <p style="color: #666; margin-bottom: 1.5rem;">Total {{ $sertifikats->count() }} sertifikat telah Anda peroleh.</p>
        
        <!-- Card View for Desktop -->
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
            @foreach($sertifikats as $sert)
                <div style="background: white; border: 2px solid var(--border-color); border-radius: 0.75rem; padding: 1.5rem; transition: all 0.3s ease; position: relative; overflow: hidden;">
                    <div style="position: absolute; top: -50%; right: -50%; width: 200px; height: 200px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); opacity: 0.05; border-radius: 50%;"></div>
                    <div style="position: relative; z-index: 1;">
                        <div style="text-align: center; margin-bottom: 1.5rem;">
                            <div style="font-size: 3rem; margin-bottom: 0.5rem;">🏅</div>
                            <h3 style="margin: 0 0 0.5rem 0; font-size: 1.1rem; color: var(--dark-color);">{{ Str::limit($sert->pelatihan->title, 40) }}</h3>
                        </div>
                        
                        <div style="background: var(--light-color); padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem; text-align: center;">
                            <small style="color: #666;">Tanggal Terbit</small>
                            <p style="margin: 0.5rem 0 0 0; font-weight: 600; color: var(--primary-color);">
                                {{ $sert->issue_date->format('d M Y') }}
                            </p>
                        </div>
                        
                        @if($sert->expiry_date)
                            <div style="background: var(--light-color); padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem; text-align: center;">
                                <small style="color: #666;">Kadaluarsa</small>
                                <p style="margin: 0.5rem 0 0 0; font-weight: 600; color: #999;">
                                    {{ $sert->expiry_date->format('d M Y') }}
                                </p>
                            </div>
                        @endif
                        
                        <div style="margin-bottom: 1rem;">
                            <span class="status-badge status-{{ strtolower($sert->status) }}">
                                @if($sert->status === 'pending')
                                    ⏳ Menunggu Konfirmasi
                                @elseif($sert->status === 'in_progress')
                                    ▶️ Sedang Diproses
                                @elseif($sert->status === 'issued' || $sert->status === 'completed')
                                    ✓ Selesai
                                @else
                                    {{ ucfirst(str_replace('_', ' ', $sert->status)) }}
                                @endif
                            </span>
                        </div>
                        
                        @if($sert->file_path)
                            <a href="{{ $sert->file_path }}" target="_blank" class="btn-primary" style="width: 100%; text-align: center; display: block; padding: 0.75rem;">
                                📥 Download PDF
                            </a>
                        @else
                            <button disabled class="btn-outline" style="width: 100%; opacity: 0.5; cursor: not-allowed;">
                                Belum Tersedia
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Table View for Mobile -->
        <div class="table-wrap" style="display: none;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Pelatihan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sertifikats as $sert)
                        <tr>
                            <td><strong>{{ Str::limit($sert->pelatihan->title, 30) }}</strong></td>
                            <td><small>{{ $sert->issue_date->format('d M Y') }}</small></td>
                            <td>
                                <span class="status-badge status-{{ strtolower($sert->status) }}" style="font-size: 0.8rem;">
                                    @if($sert->status === 'issued' || $sert->status === 'completed')
                                        ✓ Selesai
                                    @else
                                        {{ ucfirst(substr($sert->status, 0, 10)) }}
                                    @endif
                                </span>
                            </td>
                            <td>
                                @if($sert->file_path)
                                    <a href="{{ $sert->file_path }}" target="_blank" class="btn-outline" style="padding: 0.5rem 1rem; font-size: 0.85rem;">📥</a>
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

    <style>
        @media (max-width: 768px) {
            .member-card > div:first-of-type {
                display: none !important;
            }
            
            .member-card .table-wrap {
                display: block !important;
            }
        }
    </style>
@endif
@endsection

