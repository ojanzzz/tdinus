@extends('layouts.admin')

@section('admin-content')
<h1 class="page-title">Tambah Layanan</h1>

<form method="POST" action="{{ route('admin.services.store') }}" class="form-stack form-card" enctype="multipart/form-data">
    @csrf
    <label>
        Nama Layanan
        <input type="text" name="name" value="{{ old('name') }}" class="form-input" required>
    </label>
    <label>
        Deskripsi
        <textarea name="description" rows="4" class="form-input">{{ old('description') }}</textarea>
    </label>
    <label>
        Url Layanan
        <input type="url" name="url_layanan" value="{{ old('url_layanan') }}" class="form-input" placeholder="https://contoh.com atau /path/relatif">
    </label>
    <label>
        Gambar
        <input type="file" name="image" class="form-input" accept="image/*">
    </label>
    <label class="checkbox-row">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
        Aktif
    </label>
    @if($errors->any())
        <p class="form-error">{{ $errors->first() }}</p>
    @endif
    <div class="form-actions">
        <a href="{{ route('admin.services.index') }}" class="btn-outline">Batal</a>
        <button type="submit" class="btn-primary">Simpan</button>
    </div>
</form>
@endsection
