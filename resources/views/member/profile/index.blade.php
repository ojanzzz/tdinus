@extends('layouts.member')

@section('member-content')
<div class="admin-header">
    <div>
        <h1 class="page-title">Edit Profile</h1>
    </div>
    <a href="{{ route('member.dashboard') }}" class="btn-outline">Kembali Dashboard</a>
</div>

@if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

<div class="form-card">
    <form method="POST" action="/member/profile" class="form-stack" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <label>
            Nama Lengkap
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-input @error('name') is-invalid @enderror" required>
            @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </label>
        <label>
            Email
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-input @error('email') is-invalid @enderror" required>
            @error('email')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </label>
        <label>
            No Telepon
            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-input @error('phone') is-invalid @enderror">
            @error('phone')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </label>
        <label>
            Alamat
            <textarea name="address" rows="3" class="form-input @error('address') is-invalid @enderror">{{ old('address', $user->address) }}</textarea>
            @error('address')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </label>
        <label>
            Layanan Dipilih (JSON array)
            <textarea name="selected_services" rows="3" class="form-input @error('selected_services') is-invalid @enderror">{{ old('selected_services', $user->selected_services ? json_encode($user->selected_services) : '[]') }}</textarea>
            <small>Contoh: ["Jurnal Publikasi", "Pelatihan Laravel"]</small>
            @error('selected_services')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </label>
        <div class="form-actions">
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection

