@extends('layouts.admin')

@section('admin-content')
<div class="admin-header">
    <div>
        <h1 class="page-title">Admin Users</h1>
        <p class="page-subtitle">Kelola akun admin sistem.</p>
    </div>
    <a href="{{ route('admin.admin-users.create') }}" class="btn-primary">Tambah Admin</a>
</div>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert-error">{{ session('error') }}</div>
@endif

<div class="table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Dibuat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($admins as $admin)
                <tr>
                    <td>{{ $admin->name }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>{{ $admin->created_at->format('d/m/Y') }}</td>
                    <td class="table-actions">
                        <a href="{{ route('admin.admin-users.edit', $admin) }}" class="btn-outline">Edit</a>
                        @if($admin->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.admin-users.destroy', $admin) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger" onclick="return confirm('Hapus admin ini?')">Hapus</button>
                            </form>
                        @else
                            <span class="text-muted">(Anda)</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Belum ada admin.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection