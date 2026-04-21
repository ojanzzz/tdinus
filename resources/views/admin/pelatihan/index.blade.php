@extends('layouts.admin')

@section('admin-content')
<div class="admin-header">
    <div>
        <h1 class="page-title">Pelatihan</h1>
        <p class="page-subtitle">Kelola program pelatihan.</p>
    </div>
    <a href="{{ route('admin.pelatihan.create') }}" class="btn-primary">Tambah Pelatihan</a>
</div>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

<div class="table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Judul</th>
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
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->duration ?? '-' }}</td>
                    <td>Rp {{ number_format($item->price ?? 0,0,',','.') }}</td>
                    <td>
                        @if($item->image_path)
                            <img src="{{ $item->image_path }}" alt="{{ $item->title }}" class="thumb-image">
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $item->status === 'active' ? 'Aktif' : 'Nonaktif' }}</td>
                    <td class="table-actions">
                        <a href="{{ route('admin.pelatihan.edit', $item) }}" class="btn-outline">Edit</a>
                        <form method="POST" action="{{ route('admin.pelatihan.destroy', $item) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger" onclick="return confirm('Hapus pelatihan ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Belum ada pelatihan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

