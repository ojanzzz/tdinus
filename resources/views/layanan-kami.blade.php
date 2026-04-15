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
