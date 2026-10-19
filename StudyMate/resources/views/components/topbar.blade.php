{{--
  components/topbar.blade.php
  ===========================
  Komponen header utama aplikasi StudyMate:
  Logo brand, tombol notifikasi, dan tombol pintasan profil.
--}}
<header class="topbar">
  <div class="wrap">
    <a class="brand" href="/dashboard" aria-label="Beranda StudyMate">
      <span class="logo">
        <img src="{{ asset('image/e26aa.png') }}" alt="StudyMate" />
      </span>
      <span class="brand-name pj-bold">StudyMate</span>
    </a>

    <div class="top-actions">
      <a class="icon-btn" href="#notifikasi" aria-label="Notifikasi">
        <img src="{{ asset('image/7cf12.svg') }}" width="15" height="18" alt="" />
        <span class="notif-dot"></span>
      </a>
      <a class="icon-btn" href="/profil" aria-label="Profil Pengguna">
        <span class="avatar-btn">
          <img src="{{ asset('image/59e02.svg') }}" width="12" height="12" alt="" />
        </span>
      </a>
    </div>
  </div>
</header>
