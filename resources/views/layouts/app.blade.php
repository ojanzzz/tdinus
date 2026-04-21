<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="index, follow">
    <meta name="description" content="Teras Digital Nusantara (Tdinus) adalah perusahaan yang bergerak di bidang pengembangan teknologi informasi dan transformasi digital, dengan fokus pada publikasi ilmiah, jurnal, dan pelatihan.">
    <meta name="keywords" content="Teras Digital Nusantara, Tdinus, teknologi informasi, transformasi digital, publikasi ilmiah, jurnal, pelatihan digital">
    <meta name="author" content="Teras Digital Nusantara">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Open Graph / Facebook / WhatsApp -->
    <meta property="og:title" content="Teras Digital Nusantara...">
<meta property="og:image" content="http://127.0.0.1:8000/storage/gambar-berita.jpg">
<meta property="og:description" content="Teras Digital Nusantara (Tdinus) adalah...">
    <meta property="fb:app_id" content="123456789" /> {{-- Isi dengan ID jika ada --}}
<meta property="og:site_name" content="Teras Digital Nusantara">

<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:type" content="article">
<meta property="og:url" content="{{ Request::url() }}">
<meta property="og:title" content="@yield('meta_title', 'Teras Digital Nusantara')">
<meta property="og:description" content="@yield('meta_description', 'Berita terkini dari Teras Digital')">
<meta property="og:image" content="@yield('meta_image', asset('images/default-share.jpg'))">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="@yield('meta_title', 'Teras Digital Nusantara')">
<meta name="twitter:description" content="@yield('meta_description', 'Berita terkini dari Teras Digital')">
<meta name="twitter:image" content="@yield('meta_image', asset('images/default-share.jpg'))">
    @yield('meta')
    <title>@yield('title', 'Teras Digital Nusantara – Transformasi Digital Kreatif')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/images/favicon/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="/images/favicon/site.webmanifest">
    
    <!-- Preload critical assets -->
    <link rel="preload" href="/images/logo-tdinus.png" as="image">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" as="style">

<link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/news-sidebar.css">
    <link rel="stylesheet" href="/css/payments-responsive.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --global-palette1: #1181b3;
            --global-palette2: #726445;
            --global-palette3: #0962ad;
            --global-palette4: #0f0f0f;
            --global-palette5: #0c53cf;
            --global-palette6: #718099;
            --global-palette7: #ffffff;
            --global-palette8: #ffffff;
            --global-palette9: #ffffff;
            --global-palette14: #f7630c;
            --global-palette15: #ee9709;
        }
   
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: 0.01ms !important; animation-iteration-count: 1 !important; transition-duration: 0.01ms !important; }
        }
    </style>
</head>
<body>
    @include('layouts.partials._header')
    
    <!-- Skip to content -->
    <a href="#main-content" class="skip-link">Skip to content</a>

    <main id="main-content">
        @yield('content')
    </main>

    @include('layouts.partials._whatsapp-float')
    @include('layouts.partials._footer')

<script src="https://cdn.tinymce.com/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="/js/app.js"></script>
    @stack('scripts')
</body>
</html>
