@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/news-sidebar.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer">
    <style>
        .share-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin: 0 2rem 2rem;
            padding: 0;
        }

        .share-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 55px;
            height: 55px;
            border-radius: 50%;
            color: #fff;
            font-size: 24px;
            text-decoration: none;
            transition: transform 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.18);
            position: relative;
        }

        .share-btn:hover {
            transform: translateY(-4px) scale(1.06);
        }

        .share-btn .fa-brands,
        .share-btn .fa-solid,
        .share-btn .fab,
        .share-btn .fas {
            pointer-events: none;
        }

        .share-btn--facebook {
            background: linear-gradient(135deg, #1877f2, #0f5dcf);
        }

        .share-btn--x {
            background: linear-gradient(135deg, #111827, #000000);
        }

        .share-btn--whatsapp {
            background: linear-gradient(135deg, #25d366, #199c4c);
        }

        .share-btn--copy {
            background: linear-gradient(135deg, #f59e0b, #ea580c);
        }

        .share-btn--copy.is-copied {
            background: linear-gradient(135deg, #22c55e, #15803d);
        }

        .share-btn--copy.is-copied::after {
            content: 'Disalin';
            position: absolute;
            top: -36px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(15, 23, 42, 0.92);
            color: #fff;
            font-size: 12px;
            line-height: 1;
            padding: 7px 10px;
            border-radius: 999px;
            white-space: nowrap;
        }

        @media (max-width: 768px) {
            .share-buttons {
                margin: 0 1.25rem 1.5rem;
                gap: 8px;
            }

            .share-btn {
                width: 46px;
                height: 46px;
                font-size: 18px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="/js/share-buttons.js" defer></script>
@endpush

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
                        <img src="{{ optimized_asset_path($news->image_path, '/images/news1.jpg') }}"
                            alt="{{ $news->title }}" class="news-detail-image" width="1200" height="675"
                            loading="eager" decoding="async" fetchpriority="high">
                        <div class="news-detail-body">
                            <div class="news-content">
                                {!! $news->body !!}
                            </div>
                        </div>

                        {{ $shareButtons }}
                    </div>
                </div>
            </main>
        </div>
    </section>
@endsection
