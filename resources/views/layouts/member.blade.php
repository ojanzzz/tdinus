@extends('layouts.app')

@section('content')
<section class="section section-muted">
    <div class="container admin-shell">
        <aside class="admin-sidebar" id="memberSidebar">
            <button class="sidebar-toggle" id="memberToggle" onclick="toggleMemberSidebar()" title="Toggle Sidebar">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M2.5 11a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                </svg>
            </button>
            <h2 class="admin-title">Member Panel</h2>
            <nav class="admin-nav">
                <a href="{{ route('member.dashboard') }}" class="admin-link {{ request()->routeIs('member.dashboard') ? 'active' : '' }}">
                    📊 Dashboard
                </a>
                <a href="/member/profile" class="admin-link {{ request()->routeIs('member.profile.*') ? 'active' : '' }}">
                    👤 Profile
                </a>
                <a href="/member/pelatihan" class="admin-link {{ request()->routeIs('member.pelatihan.*') ? 'active' : '' }}">
                    📚 Pelatihan
                </a>
                <a href="/member/payments" class="admin-link {{ request()->routeIs('member.payments.*') ? 'active' : '' }}">
                    💳 Pembayaran
                </a>
                <a href="/member/sertifikat" class="admin-link {{ request()->routeIs('member.sertifikat.*') ? 'active' : '' }}">
                    🏅 Sertifikat
                </a>
            </nav>
        </aside>
        <div class="admin-main">
            @yield('member-content')
        </div>
    </div>
</section>
@push('scripts')
<script>
function toggleMemberSidebar() {
    const sidebar = document.getElementById('memberSidebar');
    sidebar.classList.toggle('sidebar-hidden');
}

window.addEventListener('resize', function() {
    const sidebar = document.getElementById('memberSidebar');
    if (window.innerWidth < 768) {
        sidebar.classList.add('sidebar-hidden');
    } else {
        sidebar.classList.remove('sidebar-hidden');
    }
});

// Initial check
if (window.innerWidth < 768) {
    document.getElementById('memberSidebar').classList.add('sidebar-hidden');
}

// Close sidebar when clicking on a link (mobile)
document.querySelectorAll('.admin-nav .admin-link').forEach(link => {
    link.addEventListener('click', function() {
        if (window.innerWidth < 768) {
            document.getElementById('memberSidebar').classList.add('sidebar-hidden');
        }
    });
});
</script>
@endpush
@endsection
