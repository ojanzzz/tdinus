@extends('layouts.app')

@section('content')
<section class="section section-muted">
    <div class="container">
        <h1 class="page-title">Layanan Kami</h1>
        <div class="grid-3">
            @forelse($services as $service)
                <div class="service-card">
                    <img src="{{ $service->image_path ?? '/images/journal-1.jpg' }}" alt="{{ $service->name }}" class="card-image">
                    <h3>{{ $service->name }}</h3>
                    <p>{{ $service->description }}</p>
                 <a href="{{ $service->url_layanan ? (preg_match('/^https?:\/\//', $service->url_layanan) ? $service->url_layanan : 'https://' . $service->url_layanan) : '/kontak-kami' }}" class="btn-submit" {{ $service->url_layanan ? 'target="_blank" rel="noopener noreferrer"' : '' }}>
                        Hubungi
                    </a>
                </div>
            @empty
                <div class="service-card">
                    <h3>Belum ada layanan</h3>
                    <p>Silakan tambah layanan melalui admin panel.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
