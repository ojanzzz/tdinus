@extends('layouts.admin')

@section('admin-content')
<div class="admin-header">
    <div>
        <h1 class="page-title">Sertifikat</h1>
        <p class="page-subtitle">Kelola sertifikat member.</p>
    </div>
    <a href="{{ route('admin.sertifikat.create') }}" class="btn-primary">Terbitkan Sertifikat</a>
</div>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
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
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->pelatihan->title }}</td>
                    <td>{{ $item->issue_date->format('d M Y') }}</td>
                    <td>
                        <span class="status-badge status-{{ strtolower($item->status) }}">
                            @if($item->status === 'pending')
                                Menunggu Konfirmasi
                            @elseif($item->status === 'in_progress')
                                Konfirmasi
                            @else
                                {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                            @endif
                        </span>
                    </td>
                    <td class="table-actions">
                        <a href="{{ route('admin.sertifikat.edit', $item) }}" class="btn-outline">Edit</a>
                        @if(in_array($item->status, ['pending', 'in_progress']))
                            <form method="POST" action="{{ route('admin.sertifikat.complete', $item) }}" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn-primary" onclick="return confirm('{{ $item->status === 'pending' ? 'Konfirmasi' : 'Selesaikan' }} pelatihan ini dan issue sertifikat?')">{{ $item->status === 'pending' ? 'Konfirmasi' : 'Selesaikan' }}</button>
                            </form>
                        @endif
                        <form method="POST" action="{{ route('admin.sertifikat.destroy', $item) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger" onclick="return confirm('Hapus sertifikat ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Belum ada sertifikat.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

