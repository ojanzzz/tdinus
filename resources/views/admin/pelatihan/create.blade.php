@extends('layouts.admin')

@section('admin-content')
<h1 class="page-title">Tambah Pelatihan</h1>

<form method="POST" action="{{ route('admin.pelatihan.store') }}" class="form-stack form-card" enctype="multipart/form-data">
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
        Deskripsi
        <textarea name="description" rows="6" id="description-create">{{ old('description') }}</textarea>
    </label>
    
    <label>
        Gambar
        <input type="file" name="image" class="form-input" accept="image/*">
    </label>
    <label>
        Durasi (contoh: 3 hari)
        <input type="text" name="duration" value="{{ old('duration') }}" class="form-input">
    </label>
    <label>
        Harga (Rp)
        <input type="number" name="price" step="0.01" value="{{ old('price') }}" class="form-input">
    </label>
    <label class="checkbox-row">
        <input type="checkbox" name="status" value="1" {{ old('status', true) ? 'checked' : '' }}>
        Aktif
    </label>
    @if($errors->any())
        <p class="form-error">{{ $errors->first() }}</p>
    @endif
    <div class="form-actions">
        <a href="{{ route('admin.pelatihan.index') }}" class="btn-outline">Batal</a>
        <button type="submit" class="btn-primary">Simpan</button>
    </div>
</form>
<!-- Load TinyMCE Script with API Key -->
<script src="https://cdn.tiny.cloud/1/sjhdgimwlpcym3wj2z3s0lndatqhenqfrb0a2u3ln3bj6vky/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>

<script>
    // Initialize TinyMCE
    tinymce.init({
        selector: '#description-create',
        height: 400,
        plugins: 'advlist autolink lists link image charmap code',
        toolbar: 'undo redo | formatselect | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code',
        image_advtab: true,
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px; }'
    });
</script>

@endsection

