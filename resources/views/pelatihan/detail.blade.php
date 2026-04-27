@extends('layouts.app')

@section('title', $pelatihan->title . ' - Teras Digital Nusantara')

@section('content')
<section class="section">
    <div class="container">
        <div class="news-detail">
            <article class="news-detail-card">
                @if($pelatihan->image_path)
                    <img src="{{ optimized_asset_path($pelatihan->image_path) }}" alt="{{ $pelatihan->title }}"
                        class="news-detail-image" width="1200" height="675" loading="eager" decoding="async"
                        fetchpriority="high">
                @endif
                <div class="news-detail-body">
                    <h1>{{ $pelatihan->title }}</h1>
                    <div class="news-meta">
                        @if($pelatihan->duration)
                            <span class="news-category">Durasi: {{ $pelatihan->duration }}</span>
                        @endif
                        @if($pelatihan->price)
                            <span class="news-category">Rp {{ number_format($pelatihan->price,0,',','.') }}</span>
                        @endif
                    </div>
                    <div class="news-content">
                        {!! $pelatihan->description !!}
                    </div>
                    <div class="card-actions">
                        @auth
                            @if($pelatihan->is_taken)
                                <div class="alert-success" style="margin-bottom: 1rem;">
                                    Anda sudah pernah mengambil pelatihan ini.
                                </div>
                                @if($memberPayment)
                                    <a href="{{ route('member.payments.show', $memberPayment) }}" class="btn-submit">Ke Menu Pembayaran</a>
                                @else
                                    <a href="{{ route('member.pelatihan.index') }}" class="btn-submit">Lihat Pelatihan Aktif</a>
                                @endif
                            @else
                                <form method="POST" action="{{ route('member.pelatihan.take', $pelatihan) }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn-submit">
                                        {{ optional($memberPayment)->status === 'rejected' ? 'Ambil Ulang Pelatihan' : 'Ambil Pelatihan Ini' }}
                                    </button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('login.member') }}" class="btn-submit">Login Untuk Ambil Pelatihan</a>
                        @endauth
                    </div>
                </div>
            </article>
        </div>
        <div style="margin-top: 3rem;">
            {{ $pelatihans->links() }}
        </div>
    </div>
</section>
@endsection

