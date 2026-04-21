@extends('layouts.admin')

@section('admin-content')
<div class="admin-header">
    <div>
        <h1 class="page-title">Pengaturan Member</h1>
        <p class="page-subtitle">Kelola konfigurasi untuk akun member.</p>
    </div>
    <div class="admin-header-actions">
        <a href="{{ route('admin.members.index') }}" class="btn-outline">Kelola Member</a>
        <a href="{{ route('admin.member-settings.create') }}" class="btn-primary">Tambah Pengaturan</a>
    </div>
</div>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

<div class="table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Key</th>
                <th>Value</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($settings as $setting)
                <tr>
                    <td>{{ $setting->key }}</td>
                    <td>{{ $setting->value }}</td>
                    <td>{{ $setting->description ?? '-' }}</td>
                    <td class="table-actions">
                        <a href="{{ route('admin.member-settings.edit', $setting) }}" class="btn-outline">Edit</a>
                        <form method="POST" action="{{ route('admin.member-settings.destroy', $setting) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger" onclick="return confirm('Hapus pengaturan ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Belum ada pengaturan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
