@extends('layouts.admin')

@section('admin-content')
<h1 class="page-title">Edit Pelatihan</h1>

<form method="POST" action="{{ route('admin.pelatihan.update', $pelatihan) }}" class="form-stack form-card" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <label>
        Judul
        <input type="text" name="title" value="{{ old('title', $pelatihan->title) }}" class="form-input" required>
    </label>
    <label>
        Slug (opsional)
        <input type="text" name="slug" value="{{ old('slug', $pelatihan->slug) }}" class="form-input">
    </label>
    <label>
        Deskripsi
        <textarea name="description" rows="4" class="form-input">{{ old('description', $pelatihan->description) }}</textarea>
    </label>
    <label>
        Gambar (kosongkan untuk tetap)
        @if($pelatihan->image_path)
            <img src="{{ $pelatihan->image_path }}" alt="Current" class="thumb-image">
        @endif
        <input type="file" name="image" class="form-input" accept="image/*">
    </label>
    <label>
        Durasi
        <input type="text" name="duration" value="{{ old('duration', $pelatihan->duration) }}" class="form-input">
    </label>
    <label>
        Harga (Rp)
        <input type="number" name="price" step="0.01" value="{{ old('price', $pelatihan->price) }}" class="form-input">
    </label>
    <label class="checkbox-row">
        <input type="checkbox" name="status" value="1" {{ old('status', $pelatihan->status === 'active') ? 'checked' : '' }}>
        Aktif
    </label>
    @if($errors->any())
        <p class="form-error">{{ $errors->first() }}</p>
    @endif
    <div class="form-actions">
        <a href="{{ route('admin.pelatihan.index') }}" class="btn-outline">Batal</a>
        <button type="submit" class="btn-primary">Update</button>
    </div>
</form>
@endsection

