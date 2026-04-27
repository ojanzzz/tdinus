@extends('layouts.app')

@php
    $homeSliders = $sliders ?? collect();
    $heroPreloadPath = optimized_asset_path(optional($homeSliders->first())->image_path ?? null, '/images/hero-bg.png');
@endphp

@push('preloads')
    <link rel="preload" href="{{ $heroPreloadPath }}" as="image" fetchpriority="high">
@endpush

@section('content')
<!-- Hero Section -->
<section class="kb-row-layout-hero hero-slider">
    <div class="hero-slider-track">
        @forelse($homeSliders as $slider)
            @php
                $slideImage = optimized_asset_path($slider->image_path, '/images/hero-bg.png');
            @endphp
            <div class="hero-slide">
                <img src="{{ $slideImage }}" alt="" class="hero-slide-media" width="1600" height="900"
                    @if ($loop->first) fetchpriority="high" loading="eager" decoding="sync"
                    @else loading="lazy" decoding="async" @endif>
                <div class="hero-content">
                    <h1>{{ $slider->title }}</h1>
                    @if($slider->description)
                        <p>{{ $slider->description }}</p>
                    @endif
                </div>
            </div>
        @empty
            <div class="hero-slide">
                <img src="{{ optimized_asset_path('/images/hero-bg.png') }}" alt="" class="hero-slide-media"
                    width="1600" height="900" fetchpriority="high" loading="eager" decoding="sync">
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
                @php
                    $serviceImage = optimized_asset_path($service->image_path, '/images/journal-1.jpg');
                @endphp
                <div class="hero-card">
                    <img src="{{ $serviceImage }}" alt="{{ $service->name }}" width="640" height="480"
                        loading="lazy" decoding="async">
                    <h3>{{ $service->name }}</h3>
                    @if($service->description)
                        <p>{{ $service->description }}</p>
                    @endif
                    <div class="card-actions">
  <a href="{{ $service->url_layanan ? (preg_match('/^https?:\/\//', $service->url_layanan) ? $service->url_layanan : 'https://' . $service->url_layanan) : '/kontak-kami' }}" class="btn-submit" {{ $service->url_layanan ? 'target="_blank" rel="noopener noreferrer"' : '' }}>
                        Hubungi
                    </a>
                    </div>
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
                @php
                    $newsImage = optimized_asset_path($item->image_path, '/images/news1.jpg');
                @endphp
                <article class="news-card">
                    <img src="{{ $newsImage }}" alt="{{ $item->title }}" width="640" height="400"
                        loading="lazy" decoding="async">
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
                @php
                    $pelatihanImage = optimized_asset_path($pelatihan->image_path, '/images/journal-1.jpg');
                @endphp
                <div class="hero-card">
                    <img src="{{ $pelatihanImage }}" alt="{{ $pelatihan->title }}" width="640" height="480"
                        loading="lazy" decoding="async">
                    <h3>{{ $pelatihan->title }}</h3>
                    @if($pelatihan->duration)
                        <p>{{ $pelatihan->duration }}</p>
                    @endif
                    @if($pelatihan->price)
                        <p>Rp {{ number_format($pelatihan->price,0,',','.') }}</p>
                    @endif
                    <div class="card-actions">
                        <a href="{{ route('pelatihan.detail', $pelatihan->slug ?? $pelatihan->id) }}" class="btn-primary">Lihat Detail</a>
                        @auth
                            <form method="POST" action="{{ route('member.pelatihan.take', $pelatihan) }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn-submit">Ambil Pelatihan</button>
                            </form>
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
