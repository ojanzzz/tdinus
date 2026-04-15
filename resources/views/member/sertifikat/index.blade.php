@extends('layouts.member')

@section('member-content')
<div class="admin-header">
    <h1 class="page-title">Sertifikat Saya</h1>
    <p class="page-subtitle">Daftar sertifikat yang telah Anda terima.</p>
</div>

@if($sertifikats->isEmpty())
    <div class="admin-main-empty">
        <p>Belum ada sertifikat. Ikuti pelatihan untuk mendapatkan sertifikat.</p>
        <a href="/member/pelatihan" class="btn-primary">Lihat Pelatihan</a>
    </div>
@else
    <div class="table-wrap">
      
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Pelatihan</th>
                    <th>Tanggal Terbit</th>
                    <th>Kadaluarsa</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sertifikats as $sert)
                    <tr>
                        <td>{{ $sert->pelatihan->title }}</td>
                        <td>{{ $sert->issue_date->format('d M Y') }}</td>
                        <td>{{ $sert->expiry_date?->format('d M Y') ?? 'Tidak ada' }}</td>
                        <td>
                            <span class="status-badge status-{{ strtolower($sert->status) }}">
                                @if($sert->status === 'pending')
                                    Menunggu Konfirmasi
                                @elseif($sert->status === 'in_progress')
                                    Konfirmasi
                                @else
                                    {{ ucfirst(str_replace('_', ' ', $sert->status)) }}
                                @endif
                            </span>
                        </td>
                        <td>
                            @if($sert->file_path)
                                <a href="{{ $sert->file_path }}" target="_blank" class="btn-primary" title="Download Sertifikat">📄 PDF</a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection

