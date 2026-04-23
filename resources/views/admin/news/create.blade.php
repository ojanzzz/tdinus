@extends('layouts.admin')

@section('admin-content')
<div class="admin-header">
    <h1 class="page-title">📰 Tambah Berita Baru</h1>
</div>

<div class="form-card">
    <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data" class="form-stack">
        @csrf
        
        <label>
            <span style="color: var(--dark-color); font-weight: 600;">Judul Berita</span>
            <input type="text" name="title" value="{{ old('title') }}" class="form-input" placeholder="Masukkan judul berita..." required>
            @error('title')<span class="form-error">{{ $message }}</span>@enderror
        </label>

        <label>
            <span style="color: var(--dark-color); font-weight: 600;">Slug (opsional)</span>
            <input type="text" name="slug" value="{{ old('slug') }}" class="form-input" placeholder="slug-berita">
            @error('slug')<span class="form-error">{{ $message }}</span>@enderror
        </label>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <label>
                <span style="color: var(--dark-color); font-weight: 600;">Kategori</span>
                <select name="category" id="category-select" class="form-input" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                    <option value="__new__">+ Tambah Kategori Baru</option>
                </select>
                @error('category')<span class="form-error">{{ $message }}</span>@enderror
            </label>
            <div>
                <label for="new-category-input">
                    <span style="color: var(--dark-color); font-weight: 600;">Kategori Baru</span>
                    <input type="text" id="new-category-input" name="new_category" value="{{ old('new_category') }}" class="form-input" style="display:none;" placeholder="Masukkan kategori baru">
                </label>
                @error('new_category')<span class="form-error">{{ $message }}</span>@enderror
            </div>
        </div>

        <label>
            <span style="color: var(--dark-color); font-weight: 600;">Gambar Berita</span>
            <input type="file" name="image" class="form-input" accept="image/*">
            <small style="color: #999;">Format: JPG, PNG (Maksimal 5MB)</small>
            @error('image')<span class="form-error">{{ $message }}</span>@enderror
        </label>

        <label>
            <span style="color: var(--dark-color); font-weight: 600;">Ringkasan</span>
            <textarea name="excerpt" rows="3" class="form-input" placeholder="Ringkasan singkat berita...">{{ old('excerpt') }}</textarea>
            @error('excerpt')<span class="form-error">{{ $message }}</span>@enderror
        </label>

        <label>
            <span style="color: var(--dark-color); font-weight: 600;">Isi Berita</span>
            <textarea name="body" id="news-body" rows="8" class="form-input" placeholder="Tulis isi berita di sini...">{{ old('body') }}</textarea>
            @error('body')<span class="form-error">{{ $message }}</span>@enderror
        </label>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <label>
                <span style="color: var(--dark-color); font-weight: 600;">Tanggal Publikasi</span>
                <input type="date" name="published_at" value="{{ old('published_at') }}" class="form-input">
                @error('published_at')<span class="form-error">{{ $message }}</span>@enderror
            </label>
            <label class="checkbox-row" style="align-items: flex-end; padding-bottom: 0.5rem;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                <span>Publikasikan langsung (Aktif)</span>
            </label>
        </div>

        @if($errors->any())
            <div class="alert-danger">Mohon periksa kembali form Anda. Terdapat {{ $errors->count() }} kesalahan.</div>
        @endif

        <div class="form-actions">
            <a href="{{ route('admin.news.index') }}" class="btn-outline">← Batal</a>
            <button type="submit" class="btn-primary">✓ Simpan Berita</button>
        </div>
    </form>
</div>

<script src="https://cdn.tiny.cloud/1/sjhdgimwlpcym3wj2z3s0lndatqhenqfrb0a2u3ln3bj6vky/tinymce/8/tinymce.min.js" referrerpolicy="origin" crossorigin="anonymous"></script>

<script>
    // Category selection logic
    document.getElementById('category-select').addEventListener('change', function() {
        const newInput = document.getElementById('new-category-input');
        if (this.value === '__new__') {
            newInput.style.display = 'block';
            newInput.required = true;
        } else {
            newInput.style.display = 'none';
            newInput.required = false;
            newInput.value = '';
        }
    });

    // TinyMCE initialization
    tinymce.init({
        selector: '#news-body',
        height: 400,
        plugins: 'advlist autolink lists link image charmap code',
        toolbar: 'undo redo | formatselect | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code',
        image_advtab: true,
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px; }',
        menubar: 'file edit view insert format tools table help'
    });
</script>

<style>
    @media (max-width: 768px) {
        .form-card {
            padding: 1.5rem 1rem;
        }
        
        [style*="grid-template-columns: 1fr 1fr"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>

@endsection