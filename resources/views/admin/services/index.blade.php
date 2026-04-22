@extends('layouts.admin')

@section('admin-content')
<div class="admin-header">
    <div>
        <h1 class="page-title">🛠️ Layanan Kami</h1>
        <p class="page-subtitle">Kelola daftar layanan yang ditampilkan di website.</p>
    </div>
    <a href="{{ route('admin.services.create') }}" class="btn-primary">+ Tambah Layanan</a>
</div>

@if(session('success'))
    <div class="alert-success">✓ {{ session('success') }}</div>
@endif

<div class="table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Nama Layanan</th>
                <th>URL</th>
                <th>Gambar</th>
                <th>Status</th>
                <th>Update</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($services as $service)
                <tr>
                    <td>
                        <strong>{{ $service->name }}</strong>
                    </td>
                    <td>
                        @if($service->url_layanan)
                            <a href="{{ $service->url_layanan }}" target="_blank" rel="noopener" style="color: var(--primary-color); text-decoration: none;">
                                {{ Str::limit($service->url_layanan, 40) }}
                            </a>
                        @else
                            <span style="color: #999;">-</span>
                        @endif
                    </td>
                    <td>
                        @if($service->image_path)
                            <img src="{{ $service->image_path }}" alt="{{ $service->name }}" class="thumb-image">
                        @else
                            <span style="color: #999;">-</span>
                        @endif
                    </td>
                    <td>
                        <span class="status-badge status-{{ $service->is_active ? 'completed' : 'pending' }}">
                            {{ $service->is_active ? '✓ Aktif' : '⏳ Nonaktif' }}
                        </span>
                    </td>
                    <td>
                        <small>{{ $service->updated_at->format('d M Y') }}</small>
                    </td>
                    <td class="table-actions">
                        <a href="{{ route('admin.services.edit', $service) }}" class="btn-outline" style="padding: 0.5rem 1rem; font-size: 0.85rem;">Edit</a>
                        <form method="POST" action="{{ route('admin.services.destroy', $service) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger" style="padding: 0.5rem 1rem; font-size: 0.85rem;" onclick="return confirm('Yakin hapus layanan ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 2rem; color: #999;">
                        📋 Belum ada layanan. <a href="{{ route('admin.services.create') }}" style="color: var(--primary-color);">Tambah layanan pertama</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
