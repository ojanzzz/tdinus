@extends('layouts.app')

@section('content')
<section class="section section-muted">
    <div class="container admin-shell">
        <aside class="admin-sidebar" id="adminSidebar">
            <button class="sidebar-toggle" id="sidebarToggle" onclick="toggleSidebar()" title="Toggle Sidebar">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M2.5 11a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                </svg>
            </button>
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

window.addEventListener('resize', function() {
    const sidebar = document.getElementById('adminSidebar');
    if (window.innerWidth < 768) {
        sidebar.classList.add('sidebar-hidden');
    } else {
        sidebar.classList.remove('sidebar-hidden');
    }
});

// Initial check
if (window.innerWidth < 768) {
    document.getElementById('adminSidebar').classList.add('sidebar-hidden');
}

// Close sidebar when clicking on a link (mobile)
document.querySelectorAll('.admin-link').forEach(link => {
    link.addEventListener('click', function() {
        if (window.innerWidth < 768) {
            document.getElementById('adminSidebar').classList.add('sidebar-hidden');
        }
    });
});
</script>
@endpush
@endsection

