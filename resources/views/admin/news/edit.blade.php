@extends('layouts.admin')

@section('admin-content')
<h1 class="page-title">Edit Berita</h1>

<form method="POST" action="{{ route('admin.news.update', $news) }}" class="form-stack form-card" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <label>
        Judul
        <input type="text" name="title" value="{{ old('title', $news->title) }}" class="form-input" required>
    </label>
    <label>
        Slug (opsional)
        <input type="text" name="slug" value="{{ old('slug', $news->slug) }}" class="form-input">
    </label>
    <label>
        Kategori
        <input type="text" name="category" value="{{ old('category', $news->category) }}" class="form-input">
    </label>
    <label>
        Gambar
        <input type="file" name="image" class="form-input" accept="image/*">
        @if($news->image_path)
            <small>Gambar saat ini:</small>
            <img src="{{ $news->image_path }}" alt="{{ $news->title }}" class="thumb-image">
        @endif
    </label>
    <label>
        Ringkasan
        <textarea name="excerpt" rows="3" class="form-input">{{ old('excerpt', $news->excerpt) }}</textarea>
    </label>
    <label>
        Isi Berita
        <textarea name="body" id="news-body" rows="6" class="form-input">{{ old('body', $news->body) }}</textarea>
    </label>
    
    
    <label>
        Tanggal Publikasi
        <input type="date" name="published_at" value="{{ old('published_at', optional($news->published_at)->format('Y-m-d')) }}" class="form-input">
    </label>
    <label class="checkbox-row">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $news->is_active) ? 'checked' : '' }}>
        Aktif
    </label>
    @if($errors->any())
        <p class="form-error">{{ $errors->first() }}</p>
    @endif
    <div class="form-actions">
        <a href="{{ route('admin.news.index') }}" class="btn-outline">Batal</a>
        <button type="submit" class="btn-primary">Update</button>
    </div>
</form>
<!-- Load TinyMCE Script with API Key -->

<script src="https://cdn.tiny.cloud/1/sjhdgimwlpcym3wj2z3s0lndatqhenqfrb0a2u3ln3bj6vky/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>

<script>
    // Initialize TinyMCE
    tinymce.init({
        selector: '#news-body',
        height: 400,
        plugins: 'advlist autolink lists link image charmap code',
        toolbar: 'undo redo | formatselect | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code',
        image_advtab: true,
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px; }'
    });
</script>
@endsection
