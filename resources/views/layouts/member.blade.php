@extends('layouts.app')

@section('content')
<section class="section section-muted">
    <div class="container admin-shell">
        <aside class="admin-sidebar">
            <h2 class="admin-title">Member Panel</h2>
            <nav class="admin-nav">
                <a href="{{ route('member.dashboard') }}" class="admin-link {{ request()->routeIs('member.dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="/member/profile" class="admin-link {{ request()->routeIs('member.profile.*') ? 'active' : '' }}">Profile</a>
                <a href="/member/pelatihan" class="admin-link {{ request()->routeIs('member.pelatihan.*') ? 'active' : '' }}">Pelatihan</a>
                <a href="/member/payments" class="admin-link {{ request()->routeIs('member.payments.*') ? 'active' : '' }}">Pembayaran</a>
                <a href="/member/sertifikat" class="admin-link {{ request()->routeIs('member.sertifikat.*') ? 'active' : '' }}">Sertifikat</a>
            </nav>
        </aside>
        <div class="admin-main">
            @yield('member-content')
        </div>
    </div>
</section>
@endsection
