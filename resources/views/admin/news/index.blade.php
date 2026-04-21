@extends('layouts.admin')

@section('admin-content')
<div class="admin-header">
    <div>
        <h1 class="page-title">Berita</h1>
        <p class="page-subtitle">Kelola berita dan artikel terbaru.</p>
    </div>
    <a href="{{ route('admin.news.create') }}" class="btn-primary">Tambah Berita</a>
</div>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

<div class="table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Gambar</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($news as $item)
                <tr>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->category ?? '-' }}</td>
                    <td>
                        @if($item->image_path)
                            <img src="{{ $item->image_path }}" alt="{{ $item->title }}" class="thumb-image">
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $item->is_active ? 'Aktif' : 'Draft' }}</td>
                    <td>{{ $item->published_at?->format('d M Y') ?? '-' }}</td>
                    <td class="table-actions">
                        <a href="{{ route('admin.news.edit', $item) }}" class="btn-outline">Edit</a>
                        <form method="POST" action="{{ route('admin.news.destroy', $item) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger" onclick="return confirm('Hapus berita ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Belum ada berita.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
