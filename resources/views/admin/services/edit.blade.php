@extends('layouts.admin')

@section('admin-content')
<h1 class="page-title">Edit Layanan</h1>

<form method="POST" action="{{ route('admin.services.update', $service) }}" class="form-stack form-card" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <label>
        Nama Layanan
        <input type="text" name="name" value="{{ old('name', $service->name) }}" class="form-input" required>
    </label>
    <label>
        Deskripsi
        <textarea name="description" rows="4" class="form-input">{{ old('description', $service->description) }}</textarea>
    </label>
        <label>
        Url Layanan
        <input type="url" name="url_layanan" value="{{ old('url_layanan', $service->url_layanan) }}" class="form-input" placeholder="https://contoh.com atau /path/relatif">
    </label>
    <label>
        Gambar
        <input type="file" name="image" class="form-input" accept="image/*">
        @if($service->image_path)
            <small>Gambar saat ini:</small>
            <img src="{{ $service->image_path }}" alt="{{ $service->name }}" class="thumb-image">
        @endif
    </label>
    <label class="checkbox-row">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
        Aktif
    </label>
    @if($errors->any())
        <p class="form-error">{{ $errors->first() }}</p>
    @endif
    <div class="form-actions">
        <a href="{{ route('admin.services.index') }}" class="btn-outline">Batal</a>
        <button type="submit" class="btn-primary">Update</button>
    </div>
</form>
@endsection
