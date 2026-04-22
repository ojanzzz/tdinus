@extends('layouts.admin')

@section('admin-content')
<div class="admin-header">
    <div>
        <h1 class="page-title">🏅 Sertifikat</h1>
        <p class="page-subtitle">Kelola sertifikat member dan status penerbitan.</p>
    </div>
    <a href="{{ route('admin.sertifikat.create') }}" class="btn-primary">+ Terbitkan Sertifikat</a>
</div>

@if(session('success'))
    <div class="alert-success">✓ {{ session('success') }}</div>
@endif

<div class="table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Member</th>
                <th>Pelatihan</th>
                <th>Tanggal Terbit</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sertifikats as $item)
                <tr>
                    <td><strong>{{ $item->user->name }}</strong></td>
                    <td>{{ Str::limit($item->pelatihan->title, 40) }}</td>
                    <td><small>{{ $item->issue_date->format('d M Y') }}</small></td>
                    <td>
                        <span class="status-badge status-{{ strtolower($item->status) }}">
                            @if($item->status === 'pending')
                                ⏳ Menunggu
                            @elseif($item->status === 'in_progress')
                                ▶️ Berlangsung
                            @elseif($item->status === 'issued' || $item->status === 'completed')
                                ✓ Selesai
                            @else
                                {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                            @endif
                        </span>
                    </td>
                    <td class="table-actions">
                        <a href="{{ route('admin.sertifikat.edit', $item) }}" class="btn-outline" style="padding: 0.5rem 1rem; font-size: 0.85rem;">Edit</a>
                        @if(in_array($item->status, ['pending', 'in_progress']))
                            <form method="POST" action="{{ route('admin.sertifikat.complete', $item) }}" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn-primary" style="padding: 0.5rem 1rem; font-size: 0.85rem;" onclick="return confirm('{{ $item->status === 'pending' ? 'Konfirmasi' : 'Selesaikan' }} pelatihan ini?')">
                                    {{ $item->status === 'pending' ? 'Konfirmasi' : 'Selesaikan' }}
                                </button>
                            </form>
                        @endif
                        <form method="POST" action="{{ route('admin.sertifikat.destroy', $item) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger" style="padding: 0.5rem 1rem; font-size: 0.85rem;" onclick="return confirm('Yakin hapus sertifikat ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 2rem; color: #999;">
                        📋 Belum ada sertifikat. <a href="{{ route('admin.sertifikat.create') }}" style="color: var(--primary-color);">Terbitkan sertifikat pertama</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

