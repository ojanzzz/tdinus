@extends('layouts.admin')

@section('admin-content')
<h1 class="page-title">Edit Slider</h1>

<form method="POST" action="{{ route('admin.sliders.update', $slider) }}" class="form-stack form-card" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <label>
        Judul
        <input type="text" name="title" value="{{ old('title', $slider->title) }}" class="form-input">
    </label>
    <label>
        Deskripsi
        <textarea name="description" rows="4" class="form-input">{{ old('description', $slider->description) }}</textarea>
    </label>
    <label>
        Gambar
        <input type="file" name="image" class="form-input" accept="image/*">
        @if($slider->image_path)
            <small>Gambar saat ini:</small>
            <img src="{{ $slider->image_path }}" alt="{{ $slider->title }}" class="thumb-image">
        @endif
    </label>
    <label>
        Urutan
        <input type="number" name="sort_order" value="{{ old('sort_order', $slider->sort_order) }}" class="form-input" min="0">
    </label>
    <label class="checkbox-row">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $slider->is_active) ? 'checked' : '' }}>
        Aktif
    </label>
    @if($errors->any())
        <p class="form-error">{{ $errors->first() }}</p>
    @endif
    <div class="form-actions">
        <a href="{{ route('admin.sliders.index') }}" class="btn-outline">Batal</a>
        <button type="submit" class="btn-primary">Update</button>
    </div>
</form>
@endsection
