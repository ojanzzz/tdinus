@extends('layouts.app')

@section('title', 'Pelatihan - Teras Digital Nusantara')

@section('content')
<!-- Hero Section for Pelatihan -->
<section class="kb-row-layout-hero hero-slider pelatihan-hero">
    <div class="hero-slide" style="background-image: url('/images/hero-bg.png');">
    
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="layanan-header">
            <h2>Semua Pelatihan</h2>
        </div>
        <div class="hero-grid">
            @forelse($pelatihans as $pelatihan)
                <div class="hero-card">
                    <img src="{{ $pelatihan->image_path ?? '/images/journal-1.jpg' }}" alt="{{ $pelatihan->title }}">
                    <h3>{{ $pelatihan->title }}</h3>
                    @if($pelatihan->duration)
                        <p><strong>Durasi:</strong> {{ $pelatihan->duration }}</p>
                    @endif
                    @if($pelatihan->price)
                        <p><strong>Harga:</strong> Rp {{ number_format($pelatihan->price,0,',','.') }}</p>
                    @endif
                    <div class="card-actions">
                        <div class="card-actions">
                            <a href="{{ route('pelatihan.detail', $pelatihan->slug ?? $pelatihan->id) }}" class="btn-primary">Lihat Selengkapnya</a>
                        </div>
                    <div class="share-buttons">
                    <a href="javascript:void(0)" class="share-btn facebook" data-platform="facebook"
                        data-title="{{ $pelatihan->title }}" data-url="{{ request()->url() }}"
                        data-description="{{ $pelatihan->excerpt }}" title="Facebook" rel="noopener">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="share-icon">
                            <path
                                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                        </svg>
                    </a>
                    <a href="javascript:void(0)" class="share-btn twitter" data-platform="twitter"
                        data-title="{{ $pelatihan->title }}" data-url="{{ request()->url() }}" title="Twitter" rel="noopener">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="share-icon">
                            <path
                                d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                        </svg>
                    </a>
                    <a href="javascript:void(0)" class="share-btn whatsapp" data-platform="whatsapp"
                        data-title="{{ $pelatihan->title }}" data-url="{{ request()->url() }}" title="WhatsApp" rel="noopener">
                                   <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
  <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/>
</svg>
                    </a>
                    <a href="javascript:void(0)" class="share-btn copy" data-platform="copy" data-title="{{ $pelatihan->title }}"
                        data-url="{{ request()->url() }}" title="Copy Link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" class="share-icon">
                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                        </svg>
                    </a>
                </div>
                </div>
                
            @empty
                <div class="hero-card">
                    <h3>Belum ada pelatihan</h3>
                    <p>Silakan hubungi kami untuk informasi terbaru.</p>
                </div>
            @endforelse
        </div>
        
        <div class="pagination-section">
            {{ $pelatihans->appends(request()->query())->links() }}
        </div>
    </div>
</section>
@endsection
<style>
    .share-buttons {
        display: flex;
        gap: 10px;
        margin: 20px 0;
        padding: 15px;
        border-radius: 15px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .share-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 55px;
        height: 55px;
        background: rgba(255, 255, 255, 0.25);
        border-radius: 50%;
        color: black;
        font-size: 24px;
        text-decoration: none;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(20px);
        border: 2px solid rgba(255, 255, 255, 0.4);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
        position: relative;
        overflow: hidden;
    }

    .share-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        transition: left 0.5s;
    }

    .share-btn:hover::before {
        left: 100%;
    }

    .share-icon {
        width: 24px;
        height: 24px;
    }

    .share-btn:hover {
        transform: translateY(-5px) scale(1.1);
        background: rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        animation: pulse 0.6s ease;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        50% {
            box-shadow: 0 12px 35px rgba(102, 126, 234, 0.4);
        }

        100% {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }
    }

    @media (max-width: 768px) {
        .share-buttons {
            flex-wrap: wrap;
            padding: 12px;
            gap: 8px;
        }

        .share-btn {
            width: 45px;
            height: 45px;
            font-size: 18px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const shareButtons = document.querySelectorAll('.share-btn');

        shareButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const platform = this.getAttribute('data-platform');
                const title = this.getAttribute('data-title') || document.title;
                const url = this.getAttribute('data-url') || window.location.href;

                let shareUrl = '';

                switch (platform) {
                    case 'facebook':
                        shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
                        break;
                    case 'twitter':
                        shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(title)}`;
                        break;
                    case 'whatsapp':
                        shareUrl = `https://wa.me/?text=${encodeURIComponent(title + ' ' + url)}`;
                        break;
                    case 'copy':
                        navigator.clipboard.writeText(url).then(() => {
                            this.style.background = 'rgba(0, 255, 0, 0.5)';
                            setTimeout(() => {
                                this.style.background = '';
                            }, 1000);
                            const tooltip = document.createElement('div');
                            tooltip.textContent = 'Link disalin!';
                            tooltip.style.cssText = 'position:fixed;bottom:20px;right:20px;background:green;color:white;padding:10px;border-radius:5px;z-index:9999;';
                            document.body.appendChild(tooltip);
                            setTimeout(() => tooltip.remove(), 2000);
                        });
                        return;
                }

                if (shareUrl) {
                    window.open(shareUrl, '_blank', 'width=600,height=500,scrollbars=yes,resizable=yes');
                }
            });
        });
    });
</script>


