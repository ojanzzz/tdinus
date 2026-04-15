@extends('layouts.admin')

@section('admin-content')
<h1 class="page-title">Tambah Pengaturan Admin</h1>

<form method="POST" action="{{ route('admin.admin-settings.store') }}" class="form-stack form-card">
    @csrf
    <label>
        Key
        <input type="text" name="key" value="{{ old('key') }}" class="form-input" required>
    </label>
    <label>
        Value
        <textarea name="value" rows="3" class="form-input">{{ old('value') }}</textarea>
    </label>
    <label>
        Deskripsi
        <textarea name="description" rows="2" class="form-input">{{ old('description') }}</textarea>
    </label>
    @if($errors->any())
        <p class="form-error">{{ $errors->first() }}</p>
    @endif
    <div class="form-actions">
        <a href="{{ route('admin.admin-settings.index') }}" class="btn-outline">Batal</a>
        <button type="submit" class="btn-primary">Simpan</button>
    </div>
</form>
@endsection
