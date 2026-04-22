@extends('layouts.admin')

@section('admin-content')
    <div class="admin-header">
        <h1 class="page-title">👤 Tambah Member Baru</h1>
    </div>

    <div class="form-card">
        <form method="POST" action="{{ route('admin.members.store') }}" class="form-stack">
            @csrf
            
            <label>
                <span style="color: var(--dark-color); font-weight: 600;">Nama Lengkap *</span>
                <input type="text" name="name" value="{{ old('name') }}" class="form-input" placeholder="Masukkan nama member..." required>
                @error('name')<span class="form-error">{{ $message }}</span>@enderror
            </label>

            <label>
                <span style="color: var(--dark-color); font-weight: 600;">Email *</span>
                <input type="email" name="email" value="{{ old('email') }}" class="form-input" placeholder="member@example.com" required>
                @error('email')<span class="form-error">{{ $message }}</span>@enderror
            </label>

            <label>
                <span style="color: var(--dark-color); font-weight: 600;">Nomor Telepon</span>
                <input type="text" name="phone" value="{{ old('phone') }}" class="form-input" placeholder="+62 812 3456 7890">
                @error('phone')<span class="form-error">{{ $message }}</span>@enderror
            </label>

            <label>
                <span style="color: var(--dark-color); font-weight: 600;">Alamat</span>
                <textarea name="address" class="form-input" placeholder="Jalan, Kelurahan, Kecamatan, Kota..." rows="3">{{ old('address') }}</textarea>
                @error('address')<span class="form-error">{{ $message }}</span>@enderror
            </label>

            <label>
                <span style="color: var(--dark-color); font-weight: 600;">Pilih Layanan (Bisa lebih dari satu)</span>
                <select name="selected_services[]" class="form-input" multiple required>
                    <option value="" disabled>-- Pilih layanan --</option>
                    @foreach($services as $id => $name)
                        <option value="{{ $id }}" {{ in_array($id, old('selected_services', [])) ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
                <small style="color: #999;">Tahan Ctrl/Cmd untuk memilih lebih dari satu</small>
                @error('selected_services')<span class="form-error">{{ $message }}</span>@enderror
            </label>

            <label>
                <span style="color: var(--dark-color); font-weight: 600;">Password *</span>
                <input type="password" name="password" class="form-input" placeholder="Masukkan password (minimal 8 karakter)" required>
                @error('password')<span class="form-error">{{ $message }}</span>@enderror
            </label>

            @if($errors->any())
                <div class="alert-danger">Mohon periksa kembali form Anda. Terdapat {{ $errors->count() }} kesalahan.</div>
            @endif

            <div class="form-actions">
                <a href="{{ route('admin.members.index') }}" class="btn-outline">← Batal</a>
                <button type="submit" class="btn-primary">✓ Simpan Member</button>
            </div>
        </form>
    </div>

    <style>
        @media (max-width: 768px) {
            .form-card {
                padding: 1.5rem 1rem;
            }
        }
    </style>
@endsection