@extends('layouts.member')

@section('member-content')
<div class="admin-header">
    <div>
        <h1 class="page-title">👤 Edit Profile Saya</h1>
        <p class="page-subtitle">Perbarui informasi pribadi Anda.</p>
    </div>
    <a href="{{ route('member.dashboard') }}" class="btn-outline">← Kembali</a>
</div>

@if(session('success'))
    <div class="alert-success">✓ {{ session('success') }}</div>
@endif

<div class="form-card">
    <form method="POST" action="/member/profile" class="form-stack" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <label>
                <span style="color: var(--dark-color); font-weight: 600;">Nama Lengkap</span>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-input @error('name') is-invalid @enderror" placeholder="Masukkan nama lengkap" required>
                @error('name')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </label>

            <label>
                <span style="color: var(--dark-color); font-weight: 600;">Email</span>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-input @error('email') is-invalid @enderror" placeholder="email@example.com" required>
                @error('email')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </label>
        </div>

        <label>
            <span style="color: var(--dark-color); font-weight: 600;">Nomor Telepon</span>
            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-input @error('phone') is-invalid @enderror" placeholder="+62 812 3456 7890">
            @error('phone')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </label>

        <label>
            <span style="color: var(--dark-color); font-weight: 600;">Alamat Lengkap</span>
            <textarea name="address" rows="4" class="form-input @error('address') is-invalid @enderror" placeholder="Jalan, Kelurahan, Kecamatan, Kota...">{{ old('address', $user->address) }}</textarea>
            @error('address')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </label>

        <label>
            <span style="color: var(--dark-color); font-weight: 600;">Layanan Terpilih</span>
            <textarea name="selected_services" rows="3" class="form-input @error('selected_services') is-invalid @enderror" placeholder='["Layanan 1", "Layanan 2"]'>{{ old('selected_services', $user->selected_services ? json_encode($user->selected_services) : '[]') }}</textarea>
            <small style="color: #999;">Format JSON. Contoh: ["Jurnal Publikasi", "Pelatihan Laravel"]</small>
            @error('selected_services')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </label>

        <div class="form-actions">
            <a href="{{ route('member.dashboard') }}" class="btn-outline">Batal</a>
            <button type="submit" class="btn-primary">✓ Simpan Perubahan</button>
        </div>
    </form>
</div>

<style>
    @media (max-width: 768px) {
        .form-card {
            padding: 1.5rem 1rem;
        }
        
        [style*="grid-template-columns: 1fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection

