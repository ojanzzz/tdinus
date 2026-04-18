@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="kb-row-layout-hero hero-slider">
    <div class="hero-slider-track">
        @php
            $sliders = $sliders ?? collect();
        @endphp
        @forelse($sliders as $slider)
            <div class="hero-slide" style="background-image: url('{{ $slider->image_path ?? '/images/hero-bg.png' }}');">
                <div class="hero-content">
                    <h1>{{ $slider->title }}</h1>
                    @if($slider->description)
                        <p>{{ $slider->description }}</p>
                    @endif
                </div>
            </div>
        @empty
            <div class="hero-slide" style="background-image: url('/images/hero-bg.png');">
                <div class="hero-content">
                    <h1>TINGKATKAN PUBLIKASI ILMIAH ANDA DENGAN TDINUS</h1>
                    <p>Beberapa pilihan jurnal yang dapat anda sesuaikan dengan scope penelitian</p>
                </div>
            </div>
        @endforelse
    </div>
    <div class="hero-slider-controls">
        <button class="hero-prev" aria-label="Sebelumnya">‹</button>
        <button class="hero-next" aria-label="Berikutnya">›</button>
    </div>
</section>

<!-- Journals/Services Section -->
<section class="news-section">
    <div class="container">
        <div class="layanan-header">
         <h2>Layanan Kami</h2></div>
        <div class="hero-grid">
            @forelse($services as $service)
                <div class="hero-card">
                    <img src="{{ $service->image_path ?? '/images/journal-1.jpg' }}" alt="{{ $service->name }}">
                    <h3>{{ $service->name }}</h3>
                    @if($service->description)
                        <p>{{ $service->description }}</p>
                    @endif
  <a href="{{ $service->url_layanan ? (preg_match('/^https?:\/\//', $service->url_layanan) ? $service->url_layanan : 'https://' . $service->url_layanan) : '/kontak-kami' }}" class="btn-submit" {{ $service->url_layanan ? 'target="_blank" rel="noopener noreferrer"' : '' }}>
                        Hubungi
                    </a>
                </div>
            @empty
                <div class="hero-card">
                    <h3>Belum ada layanan</h3>
                    <p>Silakan tambah layanan melalui admin panel.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Recent News Section -->
<section class="news-section">
    <div class="container">
        <h2>Berita Terbaru</h2>
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
    </div>
</section>

<!-- Pelatihan Section -->
<section class="news-section">
    <div class="container">
        <div class="layanan-header">
            <h2>Pelatihan Tersedia</h2>
        </div>
        <div class="hero-grid">
            @forelse($pelatihans ?? [] as $pelatihan)
                <div class="hero-card">
                    <img src="{{ $pelatihan->image_path ?? '/images/journal-1.jpg' }}" alt="{{ $pelatihan->title }}">
                    <h3>{{ $pelatihan->title }}</h3>
                    @if($pelatihan->duration)
                        <p>{{ $pelatihan->duration }}</p>
                    @endif
                    @if($pelatihan->price)
                        <p>Rp {{ number_format($pelatihan->price,0,',','.') }}</p>
                    @endif
                         <div class="card-actions">
                        @auth
                            <a href="{{ route('member.pelatihan.index') }}" class="btn-submit">Ambil Pelatihan</a>
                        @else
                            <a href="{{ route('login.member') }}" class="btn-submit">Login Untuk Ambil</a>
                        @endauth
                    </div>
                </div>
            @empty
                <p>Belum ada pelatihan tersedia.</p>
            @endforelse
        </div>
    </div>
</section>


@endsection
