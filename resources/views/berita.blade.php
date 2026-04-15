@extends('layouts.app')

@section('content')
<section class="section">
    <div class="container">
        <h1 class="page-title">Berita</h1>
        <div class="news-grid">
            @forelse($newsItems as $item)
                <article class="news-card">
                    <img src="{{ $item->image_path ?? '/images/news1.jpg' }}" alt="{{ $item->title }}">
                    <div class="news-card-content">
                        <span class="news-category">{{ $item->category ?? 'Berita' }}</span>
                        <h3 class="news-title">{{ $item->title }}</h3>
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
                <p>Belum ada berita.</p>
            @endforelse
        </div>

        <div class="pagination-wrap">
            {{ $newsItems->links() }}
        </div>
    </div>
</section>
@endsection
