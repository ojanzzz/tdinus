@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="container">

            <h1 class="page-title">Berita</h1>
            <div class="news-layout">
                <main class="news-main">
                    <div class="news-grid">
                        @forelse($newsItems as $item)
                            <article class="news-card">
                                <img src="{{ $item->image_path ?? '/images/news1.jpg' }}" alt="{{ $item->title }}">
                                <div class="news-card-content">
                                    <h3 class="news-title">{{ $item->title }}</h3>
                                    <span class="news-category">{{ $item->category ?? 'Berita' }}</span>

                                    <p class="news-excerpt">{{ $item->excerpt }}</p>
                                    <div class="news-meta">
                                        <span>By TDINUS</span>
                                        <span>•</span>
                                        <time>{{ optional($item->published_at)->format('d M Y') }}</time>
                                    </div>
                                    <a href="/berita/{{ $item->slug }}" class="news-readmore">Baca Selengkapnya</a>
                                </div>
                            </article>
                        @empty
                            <p>Belum ada berita di kategori ini.</p>
                        @endforelse
                    </div>
                    <div class="pagination-wrap">
                        {{ $newsItems->appends(request()->query())->links() }}
                    </div>
                </main>
                <aside class="news-sidebar">
                    <div class="sidebar-card">
                        <h3>Kategori Berita</h3>
                        <ul class="category-list">
                            <li>
                                <a href="/berita" class="{{ !request('category') ? 'active' : '' }}">
                                    Semua
                                </a>
                            </li>
                            @forelse($categories as $category)
                                @php
                                    $count = app(\App\Models\News::class)->where('is_active', true)
                                        ->where('category', $category)
                                        ->count();
                                @endphp
                                <li>
                                    <a href="/berita?category={{ urlencode($category) }}"
                                        class="{{ request('category') == $category ? 'active' : '' }}">
                                        {{ $category }} ({{ $count }})
                                    </a>
                                </li>
                            @empty
                                <li>Tidak ada kategori</li>
                            @endforelse
                        </ul>
                    </div>
                </aside>
            </div>

        </div>
    </section>
@endsection