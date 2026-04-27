@extends('layouts.app')
@section('meta_title', $newsItems->first()->title ?? 'Berita Terbaru')
@section('meta_description', Str::limit(strip_tags($newsItems->first()->excerpt ?? 'Baca berita terbaru kami'), 150))
@section('meta_image', asset('storage/' . ($newsItems->first()->image ?? 'default-image.jpg')))

@push('styles')
    <link rel="stylesheet" href="/css/news-sidebar.css">
@endpush

@section('content')
    <section class="section">
        <div class="container">

            <h1 class="page-title">Berita</h1>
            <div class="news-layout">
                <main class="news-main">
                    <div class="news-grid">
                        @forelse($newsItems as $item)
                            @php
                                $newsImage = optimized_asset_path($item->image_path, '/images/news1.jpg');
                            @endphp
                            <article class="news-card">
                                <img src="{{ $newsImage }}" alt="{{ $item->title }}" width="640" height="400"
                                    loading="lazy" decoding="async">
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
