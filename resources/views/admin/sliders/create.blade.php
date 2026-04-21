@extends('layouts.admin')

@section('admin-content')
<h1 class="page-title">Tambah Slider</h1>

<form method="POST" action="{{ route('admin.sliders.store') }}" class="form-stack form-card" enctype="multipart/form-data">
    @csrf
    <label>
        Judul
        <input type="text" name="title" value="{{ old('title') }}" class="form-input">
    </label>
    <label>
        Deskripsi
        <textarea name="description" rows="4" class="form-input">{{ old('description') }}</textarea>
    </label>
    <label>
        Gambar
        <input type="file" name="image" class="form-input" accept="image/*">
    </label>
    <label>
        Urutan
        <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="form-input" min="0">
    </label>
    <label class="checkbox-row">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
        Aktif
    </label>
    @if($errors->any())
        <p class="form-error">{{ $errors->first() }}</p>
    @endif
    <div class="form-actions">
        <a href="{{ route('admin.sliders.index') }}" class="btn-outline">Batal</a>
        <button type="submit" class="btn-primary">Simpan</button>
    </div>
</form>
@endsection
