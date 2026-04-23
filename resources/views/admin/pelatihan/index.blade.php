@extends('layouts.admin')

@section('admin-content')
<div class="admin-header">
    <div>
        <h1 class="page-title">📚 Pelatihan</h1>
        <p class="page-subtitle">Kelola program pelatihan dan kursus online.</p>
    </div>
    <a href="{{ route('admin.pelatihan.create') }}" class="btn-primary">+ Tambah Pelatihan</a>
</div>

@if(session('success'))
    <div class="alert-success">✓ {{ session('success') }}</div>
@endif

<div class="table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Judul Pelatihan</th>
                <th>Durasi</th>
                <th>Harga</th>
                <th>Gambar</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pelatihans as $item)
                <tr>
                    <td><strong>{{ Str::limit($item->title, 35) }}</strong></td>
                    <td>
                        <small>{{ $item->duration ?? '-' }}</small>
                    </td>
                    <td>
                        <strong style="color: var(--primary-color);">
                            @if($item->price > 0)
                                Rp {{ number_format($item->price ?? 0, 0, ',', '.') }}
                            @else
                                Gratis
                            @endif
                        </strong>
                    </td>
                    <td>
                        @if($item->image_path)
                            <img src="{{ $item->image_path }}" alt="{{ $item->title }}" class="thumb-image">
                        @else
                            <span style="color: #999;">-</span>
                        @endif
                    </td>
                    <td>
                        <span class="status-badge status-{{ $item->status === 'active' ? 'completed' : 'pending' }}">
                            {{ $item->status === 'active' ? '✓ Aktif' : '⏳ Nonaktif' }}
                        </span>
                    </td>
                    <td class="table-actions">
                        <a href="{{ route('admin.pelatihan.edit', $item) }}" class="btn-outline" style="padding: 0.5rem 1rem; font-size: 0.85rem;">Edit</a>
                        <form method="POST" action="{{ route('admin.pelatihan.destroy', $item) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger" style="padding: 0.5rem 1rem; font-size: 0.85rem;" onclick="return confirm('Yakin hapus pelatihan ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 2rem; color: #999;">
                        📋 Belum ada pelatihan. <a href="{{ route('admin.pelatihan.create') }}" style="color: var(--primary-color);">Buat pelatihan pertama</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

