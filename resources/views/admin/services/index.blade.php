@extends('layouts.admin')

@section('admin-content')
<div class="admin-header">
    <div>
        <h1 class="page-title">Layanan Kami</h1>
        <p class="page-subtitle">Kelola daftar layanan yang ditampilkan.</p>
    </div>
    <a href="{{ route('admin.services.create') }}" class="btn-primary">Tambah Layanan</a>
</div>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

<div class="table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Gambar</th>
                <th>Status</th>
                <th>Terakhir Update</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($services as $service)
                <tr>
                    <td>{{ $service->name }}</td>
                    <td>
                        @if($service->image_path)
                            <img src="{{ $service->image_path }}" alt="{{ $service->name }}" class="thumb-image">
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $service->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                    <td>{{ $service->updated_at->format('d M Y') }}</td>
                    <td class="table-actions">
                        <a href="{{ route('admin.services.edit', $service) }}" class="btn-outline">Edit</a>
                        <form method="POST" action="{{ route('admin.services.destroy', $service) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger" onclick="return confirm('Hapus layanan ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Belum ada layanan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
