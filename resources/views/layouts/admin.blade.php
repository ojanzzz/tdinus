@extends('layouts.app')

@section('content')
<section class="section section-muted">
    <div class="container admin-shell">
        <aside class="admin-sidebar" id="adminSidebar">
            <button class="sidebar-toggle" id="sidebarToggle" onclick="toggleSidebar()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M2.5 12V6h11v6h-11zm0-5V3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5V7h-11z"/>
                </svg>
            </button>
            <h2 class="admin-title">Admin Panel</h2>
            <nav class="admin-nav">
                <a href="{{ route('admin.dashboard') }}" class="admin-link">Dashboard</a>
                <a href="{{ route('admin.sliders.index') }}" class="admin-link">Slider Hero</a>
                <a href="{{ route('admin.members.index') }}" class="admin-link">Member</a>
                <a href="{{ route('admin.services.index') }}" class="admin-link">Layanan Kami</a>
<a href="{{ route('admin.news.index') }}" class="admin-link">Berita</a>
                <a href="/admin/pelatihan" class="admin-link">Pelatihan</a>
                <a href="/admin/sertifikat" class="admin-link">Sertifikat</a>
                <a href="{{ route('admin.admin-users.index') }}" class="admin-link">Admin Users</a>
                <a href="{{ route('admin.payments.index') }}" class="admin-link">Pembayaran</a>

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
</script>
@endpush
@endsection

