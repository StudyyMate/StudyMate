{{--
  layouts/nav.blade.php / components/nav.blade.php
  ================================================
  Bottom Navigation Bar aplikasi StudyMate.
  Mendukung deteksi halaman aktif secara otomatis via request()->is().
--}}
<nav class="nav" aria-label="Navigasi utama">
  <ul class="pj-bold">
    <li>
      <a href="/dashboard" class="{{ request()->is('dashboard*') || request()->is('cari*') || request()->is('hasil*') ? 'active' : '' }}" {!! (request()->is('dashboard*') || request()->is('cari*') || request()->is('hasil*')) ? 'aria-current="page"' : '' !!}>
        <span class="ico"><img src="{{ asset('image/3f680.svg') }}" width="19" height="19" alt="" /></span>
        <span>Beranda</span>
      </a>
    </li>
    <li>
      <a href="/chat" class="{{ request()->is('chat*') ? 'active' : '' }}" {!! request()->is('chat*') ? 'aria-current="page"' : '' !!}>
        <span class="ico">
          <img src="{{ asset('image/49218.svg') }}" width="18.3333" height="18.3333" alt="" />
          <span class="count">3</span>
        </span>
        <span>Chat</span>
      </a>
    </li>
    <li>
      <a href="/jadwal" class="{{ request()->is('jadwal*') || request()->is('validasi*') || request()->is('materi*') || request()->is('kuis*') ? 'active' : '' }}" {!! (request()->is('jadwal*') || request()->is('validasi*') || request()->is('materi*') || request()->is('kuis*')) ? 'aria-current="page"' : '' !!}>
        <span class="ico"><img src="{{ asset('image/f3646.svg') }}" width="19" height="19" alt="" /></span>
        <span>Jadwal</span>
      </a>
    </li>
    <li>
      <a href="/profil" class="{{ request()->is('profil*') ? 'active' : '' }}" {!! request()->is('profil*') ? 'aria-current="page"' : '' !!}>
        <span class="ico"><img src="{{ asset('image/ff651.svg') }}" width="19" height="19" alt="" /></span>
        <span>Profil</span>
      </a>
    </li>
  </ul>
</nav>