@extends('layouts.admin')

@section('admin-content')
<div class="admin-header">
    <div>
        <h1 class="page-title">🖼️ Slider Hero</h1>
        <p class="page-subtitle">Kelola slide gambar, judul, dan deskripsi di halaman utama.</p>
    </div>
    <a href="{{ route('admin.sliders.create') }}" class="btn-primary">+ Tambah Slider</a>
</div>

@if(session('success'))
    <div class="alert-success">✓ {{ session('success') }}</div>
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
                    <td><strong>{{ Str::limit($slider->title, 40) }}</strong></td>
                    <td>
                        @if($slider->image_path)
                            <img src="{{ $slider->image_path }}" alt="{{ $slider->title }}" class="thumb-image">
                        @else
                            <span style="color: #999;">-</span>
                        @endif
                    </td>
                    <td>
                        <span style="background: var(--light-color); padding: 0.25rem 0.75rem; border-radius: 0.3rem; font-weight: 600;">
                            {{ $slider->sort_order }}
                        </span>
                    </td>
                    <td>
                        <span class="status-badge status-{{ $slider->is_active ? 'completed' : 'pending' }}">
                            {{ $slider->is_active ? '✓ Aktif' : '⏳ Nonaktif' }}
                        </span>
                    </td>
                    <td class="table-actions">
                        <a href="{{ route('admin.sliders.edit', $slider) }}" class="btn-outline" style="padding: 0.5rem 1rem; font-size: 0.85rem;">Edit</a>
                        <form method="POST" action="{{ route('admin.sliders.destroy', $slider) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger" style="padding: 0.5rem 1rem; font-size: 0.85rem;" onclick="return confirm('Yakin hapus slider ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 2rem; color: #999;">
                        📋 Belum ada slider. <a href="{{ route('admin.sliders.create') }}" style="color: var(--primary-color);">Buat slider pertama</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
