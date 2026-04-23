@extends('layouts.app')

@section('content')
<section class="section section-muted">
    <div class="container admin-shell">
        <button class="sidebar-toggle sticky-toggle" id="sidebarToggle" onclick="toggleSidebar()" title="Toggle Sidebar" style="order: -1; margin-bottom: 1rem; width: 100%;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                <path d="M2.5 11a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
            </svg>
        </button>
        <aside class="admin-sidebar" id="adminSidebar">
            <h2 class="admin-title">Admin Panel</h2>
            <nav class="admin-nav">
                <a href="{{ route('admin.dashboard') }}" class="admin-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    📊 Dashboard
                </a>
                <a href="{{ route('admin.sliders.index') }}" class="admin-link {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}">
                    🖼️ Slider Hero
                </a>
                <a href="{{ route('admin.members.index') }}" class="admin-link {{ request()->routeIs('admin.members.*') ? 'active' : '' }}">
                    👥 Member
                </a>
                <a href="{{ route('admin.services.index') }}" class="admin-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                    🛠️ Layanan Kami
                </a>
                <a href="{{ route('admin.news.index') }}" class="admin-link {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                    📰 Berita
                </a>
                <a href="/admin/pelatihan" class="admin-link {{ request()->is('admin/pelatihan*') ? 'active' : '' }}">
                    📚 Pelatihan
                </a>
                <a href="/admin/sertifikat" class="admin-link {{ request()->is('admin/sertifikat*') ? 'active' : '' }}">
                    🏅 Sertifikat
                </a>
                <a href="{{ route('admin.admin-users.index') }}" class="admin-link {{ request()->routeIs('admin.admin-users.*') ? 'active' : '' }}">
                    🔐 Admin Users
                </a>
                <a href="{{ route('admin.payments.index') }}" class="admin-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                    💳 Pembayaran
                </a>
            </nav>
        </aside>
        <div class="admin-main">
            @yield('admin-content')
        </div>
    </div>
</section>
@push('scripts')
<script>
function toggleSidebar() {
    const sidebar = document.getElementById('adminSidebar');
    sidebar.classList.toggle('sidebar-hidden');
}

// Toggle sidebar (optional hide/show)
window.addEventListener('resize', function() {
    const sidebar = document.getElementById('adminSidebar');
    if (window.innerWidth >= 768) {
        sidebar.classList.remove('sidebar-hidden');
    }
});
</script>
@endpush
@endsection

