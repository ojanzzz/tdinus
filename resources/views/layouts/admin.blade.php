@extends('layouts.app')

@section('content')
<section class="section section-muted">
    <div class="container admin-shell">
        <aside class="admin-sidebar">
            <h2 class="admin-title">Admin Panel</h2>
            <nav class="admin-nav">
                <a href="{{ route('admin.dashboard') }}" class="admin-link">Dashboard</a>
                <a href="{{ route('admin.sliders.index') }}" class="admin-link">Slider Hero</a>
                <a href="{{ route('admin.members.index') }}" class="admin-link">Member</a>
                <a href="{{ route('admin.services.index') }}" class="admin-link">Layanan Kami</a>
<a href="{{ route('admin.news.index') }}" class="admin-link">Berita</a>
                <a href="/admin/pelatihan" class="admin-link">Pelatihan</a>
                <a href="/admin/sertifikat" class="admin-link">Sertifikat</a>
                <a href="{{ route('admin.admin-settings.index') }}" class="admin-link">Pengaturan Admin</a>
                <a href="{{ route('admin.member-settings.index') }}" class="admin-link">Pengaturan Member</a>
            </nav>
        </aside>
        <div class="admin-main">
            @yield('admin-content')
        </div>
    </div>
</section>
@endsection

