@extends('layouts.admin')

@section('admin-content')
<div class="admin-header">
    <div>
        <h1 class="page-title">Slider Hero</h1>
        <p class="page-subtitle">Kelola slide gambar, judul, dan deskripsi.</p>
    </div>
    <a href="{{ route('admin.sliders.create') }}" class="btn-primary">Tambah Slider</a>
</div>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

<div class="table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Gambar</th>
                <th>Urutan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sliders as $slider)
                <tr>
                    <td>{{ $slider->title }}</td>
                    <td>
                        @if($slider->image_path)
                            <img src="{{ $slider->image_path }}" alt="{{ $slider->title }}" class="thumb-image">
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $slider->sort_order }}</td>
                    <td>{{ $slider->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                    <td class="table-actions">
                        <a href="{{ route('admin.sliders.edit', $slider) }}" class="btn-outline">Edit</a>
                        <form method="POST" action="{{ route('admin.sliders.destroy', $slider) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger" onclick="return confirm('Hapus slider ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Belum ada slider.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
