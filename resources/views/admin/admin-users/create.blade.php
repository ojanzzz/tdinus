@extends('layouts.admin')

@section('admin-content')
<h1 class="page-title">Tambah Admin</h1>

<form method="POST" action="{{ route('admin.admin-users.store') }}" class="form-stack form-card">
    @csrf
    <label>
        Nama Lengkap
        <input type="text" name="name" value="{{ old('name') }}" class="form-input" required>
    </label>
    <label>
        Email
        <input type="email" name="email" value="{{ old('email') }}" class="form-input" required>
    </label>
    <label class="password-group">
        Password
        <div class="password-input">
            <input type="password" id="password" name="password" class="form-input" required minlength="6">
            <button type="button" class="password-toggle" onclick="togglePassword('password')">👁</button>
        </div>
    </label>
    <label class="password-group">
        Konfirmasi Password
        <div class="password-input">
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required minlength="6">
            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">👁</button>
        </div>
    </label>
    @if($errors->any())
        <p class="form-error">{{ $errors->first() }}</p>
    @endif
    <div class="form-actions">
        <a href="{{ route('admin.admin-users.index') }}" class="btn-outline">Batal</a>
        <button type="submit" class="btn-primary">Simpan</button>
    </div>
</form>

@push('scripts')
<script>
function togglePassword(id) {
    const input = document.getElementById(id);
    const toggle = input.nextElementSibling;
    if (input.type === 'password') {
        input.type = 'text';
        toggle.textContent = '🙈';
    } else {
        input.type = 'password';
        toggle.textContent = '👁';
    }
}
</script>
@endpush
@endsection