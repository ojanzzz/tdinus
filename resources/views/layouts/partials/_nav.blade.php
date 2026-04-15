<nav class="main-navigation">
    <ul class="menu-list @if(isset($mobile)) menu-list-mobile @else menu-list-desktop @endif">
        <li class="menu-item {{ request()->is('/') ? 'current-menu-item' : '' }}">
            <a href="/">Beranda</a>
        </li>
      <li class="menu-item {{ request()->is('berita') ? 'current-menu-item' : '' }}">
            <a href="/berita">Berita</a>
        </li>
        <li class="menu-item {{ request()->is('layanan-kami') ? 'current-menu-item' : '' }}">
            <a href="/layanan-kami">Layanan Kami</a>
        </li>

        <li class="menu-item {{ request()->is('pelatihan') ? 'current-menu-item' : '' }}">
            <a href="/pelatihan">Pelatihan</a>
        </li>
          <li class="menu-item {{ request()->is('tentang') ? 'current-menu-item' : '' }}">
            <a href="/tentang">Tentang</a>
        </li>
        <li class="menu-item {{ request()->is('kontak-kami') ? 'current-menu-item' : '' }}">
            <a href="/kontak-kami">Kontak Kami</a>
        </li>
    </ul>
</nav>
