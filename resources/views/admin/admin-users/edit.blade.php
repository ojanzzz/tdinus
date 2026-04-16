@extends('layouts.admin')

@section('admin-content')
<h1 class="page-title">Edit Admin</h1>

<form method="POST" action="{{ route('admin.admin-users.update', $admin) }}" class="form-stack form-card">
    @csrf
    @method('PUT')
    <label>
        Nama Lengkap
        <input type="text" name="name" value="{{ old('name', $admin->name) }}" class="form-input" required>
    </label>
    <label>
        Email
        <input type="email" name="email" value="{{ old('email', $admin->email) }}" class="form-input" required>
    </label>
    <label class="password-group">
        Password Baru (kosongkan jika tidak ingin mengubah)
        <div class="password-input">
            <input type="password" id="password" name="password" class="form-input" minlength="6">
            <button type="button" class="password-toggle" onclick="togglePassword('password')">👁</button>
        </div>
    </label>
    <label class="password-group">
        Konfirmasi Password Baru
        <div class="password-input">
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" minlength="6">
            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">👁</button>
        </div>
    </label>
    @if($errors->any())
        <p class="form-error">{{ $errors->first() }}</p>
    @endif
    <div class="form-actions">
        <a href="{{ route('admin.admin-users.index') }}" class="btn-outline">Batal</a>
        <button type="submit" class="btn-primary">Update</button>
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