@extends('layouts.admin')

@section('admin-content')
<div class="admin-header">
    <div>
        <h1 class="page-title">📰 Berita</h1>
        <p class="page-subtitle">Kelola berita dan artikel terbaru.</p>
    </div>
    <a href="{{ route('admin.news.create') }}" class="btn-primary">+ Tambah Berita</a>
</div>

@if(session('success'))
    <div class="alert-success">✓ {{ session('success') }}</div>
@endif

<div class="member-card">
    <div style="display: flex; gap: 1rem; flex-wrap: wrap; margin-bottom: 1.5rem;">
        <input type="text" id="searchInput" placeholder="🔍 Cari berita..." class="form-input" style="flex: 1; min-width: 250px;">
        <button onclick="filterNews()" class="btn-primary">Cari</button>
    </div>
</div>

<div class="table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Gambar</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="newsTableBody">
            @forelse($news as $item)
                <tr>
                    <td>
                        <strong>{{ Str::limit($item->title, 40) }}</strong>
                    </td>
                    <td>
                        <span style="background: var(--light-color); padding: 0.25rem 0.75rem; border-radius: 0.3rem; font-size: 0.85rem;">
                            {{ $item->category ?? '-' }}
                        </span>
                    </td>
                    <td>
                        @if($item->image_path)
                            <img src="{{ $item->image_path }}" alt="{{ $item->title }}" class="thumb-image">
                        @else
                            <span style="color: #999;">-</span>
                        @endif
                    </td>
                    <td>
                        <span class="status-badge status-{{ $item->is_active ? 'completed' : 'pending' }}">
                            {{ $item->is_active ? '✓ Aktif' : '⏳ Draft' }}
                        </span>
                    </td>
                    <td>
                        <small>{{ $item->published_at?->format('d M Y') ?? '-' }}</small>
                    </td>
                    <td class="table-actions">
                        <a href="{{ route('admin.news.edit', $item) }}" class="btn-outline" style="padding: 0.5rem 1rem; font-size: 0.85rem;">Edit</a>
                        <form method="POST" action="{{ route('admin.news.destroy', $item) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger" style="padding: 0.5rem 1rem; font-size: 0.85rem;" onclick="return confirm('Yakin hapus berita ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 2rem; color: #999;">
                        📋 Belum ada berita. <a href="{{ route('admin.news.create') }}" style="color: var(--primary-color);">Buat berita pertama Anda</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
function filterNews() {
    const searchValue = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#newsTableBody tr');
    
    rows.forEach(row => {
        const title = row.cells[0].textContent.toLowerCase();
        const category = row.cells[1].textContent.toLowerCase();
        
        if (title.includes(searchValue) || category.includes(searchValue)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// Enable search on Enter
document.getElementById('searchInput').addEventListener('keyup', function(e) {
    if (e.key === 'Enter') {
        filterNews();
    }
});
</script>
@endsection
