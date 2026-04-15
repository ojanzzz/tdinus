<header id="masthead" class="site-header">
    <div id="main-header" class="site-header-wrap">
        <div class="site-main-header-wrap site-header-row-container site-header-row-layout-contained">
            <div class="site-header-row-container-inner">
                <div class="site-container">
                    <div
                        class="site-main-header-inner-wrap site-header-row site-header-row-has-sides site-header-row-no-center">
                        <!-- Logo -->
                        <div class="site-header-main-section-left site-header-section">
                            <div class="site-branding">
                                <a href="/" class="brand has-logo-image">
                                    <img src="/images/logo-tdinus.png" alt="Teras Digital Nusantara"
                                        class="custom-logo">
                                </a>
                            </div>
                        </div>

                        <!-- Desktop Nav -->
                        <div class="site-header-main-section-right site-header-section header-nav desktop-only">
                            @include('layouts.partials._nav')
                            <div class="header-actions">
                                @auth
                                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('member.dashboard') }}"
                                        class="btn-outline">Dashboard</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="btn-outline">Logout</button>
                                    </form>
                                @else
                                    {{-- <a href="{{ route('login.show', 'admin') }}" class="btn-outline">Login Admin</a>
                                    --}}
                                    <a href="{{ route('login.show', 'member') }}" class="btn-primary">Login Member</a>
                                @endauth
                            </div>
                        </div>

                        <!-- Mobile Menu Button -->
                        <div class="site-header-main-section-right site-header-section mobile-only">
                            <button id="mobile-menu-toggle" class="hamburger" aria-label="Toggle navigation"
                                aria-expanded="false" aria-controls="mobile-nav">
                                <span></span>
                                <span></span>
                                <span></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Offcanvas Nav -->
    <div id="mobile-nav" class="offcanvas-nav mobile-only">
        <div class="offcanvas-inner">
            <div class="offcanvas-header">
                <h2 class="offcanvas-title">Menu</h2>
                <button id="mobile-nav-close" class="offcanvas-close" aria-label="Close menu">&times;</button>
            </div>
            @include('layouts.partials._nav', ['mobile' => true])
            <div class="mobile-actions">
                @auth
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('member.dashboard') }}"
                        class="btn-outline">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-outline">Logout</button>
                    </form>
                @else
                    {{-- <a href="{{ route('login.show', 'admin') }}" class="btn-outline">Login Admin</a> --}}
                    <a href="{{ route('login.show', 'member') }}" class="btn-primary">Login Member</a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Mobile Overlay -->
    <div id="mobile-overlay" class="mobile-overlay mobile-only"></div>
</header>