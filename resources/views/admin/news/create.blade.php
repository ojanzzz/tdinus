@extends('layouts.admin')

@section('admin-content')
<h1 class="page-title">Tambah Berita</h1>

<form method="POST" action="{{ route('admin.news.store') }}" class="form-stack form-card" enctype="multipart/form-data">
    @csrf
    <label>
        Judul
        <input type="text" name="title" value="{{ old('title') }}" class="form-input" required>
    </label>
    <label>
        Slug (opsional)
        <input type="text" name="slug" value="{{ old('slug') }}" class="form-input">
    </label>
    <label>
        Kategori
        <input type="text" name="category" value="{{ old('category') }}" class="form-input">
    </label>
    <label>
        Gambar
        <input type="file" name="image" class="form-input" accept="image/*">
    </label>
    <label>
        Ringkasan
        <textarea name="excerpt" rows="3" class="form-input">{{ old('excerpt') }}</textarea>
    </label>
    <label>
        Isi Berita
        <textarea name="body" rows="6" class="form-input">{{ old('body') }}</textarea>
    </label>
    <label>
        Tanggal Publikasi
        <input type="date" name="published_at" value="{{ old('published_at') }}" class="form-input">
    </label>
    <label class="checkbox-row">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
        Aktif
    </label>
    @if($errors->any())
        <p class="form-error">{{ $errors->first() }}</p>
    @endif
    <div class="form-actions">
        <a href="{{ route('admin.news.index') }}" class="btn-outline">Batal</a>
        <button type="submit" class="btn-primary">Simpan</button>
    </div>
</form>
@endsection
