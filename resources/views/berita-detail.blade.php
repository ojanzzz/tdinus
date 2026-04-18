@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="news-layout">
            <main class="news-main">
                <div class="container news-detail">
                    <div class="news-detail-header">
                        <a href="/berita" class="btn-outline">Kembali</a>
                    </div>
                    <div class="news-detail-card">
                        <div class="news-detail-body">
                            <h1>{{ $news->title }}</h1>
                            <span class="news-category">{{ $news->category ?? 'Berita' }}</span>

                            <div class="news-meta">
                                <span>By TDINUS</span>
                                <span>•</span>
                                <time>{{ optional($news->published_at)->format('d M Y') }}</time>
                            </div>
                            <p class="news-excerpt">{{ $news->excerpt }}</p>

                        </div>
                        <img src="{{ $news->image_path ?? '/images/news1.jpg' }}" alt="{{ $news->title }}"
                            class="news-detail-image">
                        <div class="news-detail-body">

                            <div class="news-content">
                                {!! $news->body !!}
                            </div>
                        </div>
                        <div class="share-buttons">
                            <a href="javascript:void(0)" class="share-btn facebook" data-platform="facebook"
                                data-url="https://tdinus.com/berita/{{ $news->slug }}"
                                data-description="{{ $news->excerpt }}" title="Facebook" rel="noopener">
                                <svg viewBox="0 0 24 24" fill="currentColor" class="share-icon">
                                    <path
                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                            </a>
                            <a href="javascript:void(0)" class="share-btn x" data-platform="x"
                                data-title="{{ $news->title }}" data-url="https://tdinus.com/berita/{{ $news->slug }}"
                                title="X" rel="noopener">
                                <svg viewBox="0 0 24 24" fill="currentColor" class="share-icon">
                                    <path
                                        d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.487 3.24H4.443L17.61 20.644Z" />
                                    d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0
                                    002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095
                                    4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904
                                    4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936
                                    4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995
                                    13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935
                                    9.935 0 0024 4.59z" />
                                </svg>
                            </a>
                            <a href="javascript:void(0)" class="share-btn whatsapp" data-platform="whatsapp"
                                data-title="{{ $news->title }}" data-url="{{ request()->url() }}" title="WhatsApp"
                                rel="noopener">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                    class="bi bi-whatsapp" viewBox="0 0 16 16">
                                    <path
                                        d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558 .064 7.926c0 1.399 .366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79 .965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445 .099-.133 .197-.513 .646-.627 .775-.114 .133-.232 .148-.43 .05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304 .088-.403 .087-.088 .197-.232 .296-.346 .1-.114 .133-.198 .198-.33 .065-.134 .034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73 .73 0 0 0-.529 .247c-.182 .198-.691 .677-.691 1.654s .71 1.916 .81 2.049c .098 .133 1.394 2.132 3.383 2.992 .47 .205 .84 .326 1.129 .418 .475 .152 .904 .129 1.246 .08 .38-.058 1.171-.48 1.338-.943 .164-.464 .164-.86 .114-.943-.049-.084-.182-.133-.38-.232" />
                                </svg>
                            </a>
                            <a href="javascript:void(0)" class="share-btn copy" data-platform="copy"
                                data-title="{{ $news->title }}" data-url="{{ request()->url() }}" title="Copy Link">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" class="share-icon">
                                    <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                </svg>
                            </a>
                        </div>
                    </div>

                </div>
            </main>
            <aside class="news-sidebar">

                <div class="sidebar-card">
                    <h3>Kategori Berita</h3>
                    <ul class="category-list">
                        <li>
                            <a href="/berita" class="{{ $news->category ? '' : 'active' }}">
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
                                    class="{{ $news->category == $category ? 'active' : '' }}">
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