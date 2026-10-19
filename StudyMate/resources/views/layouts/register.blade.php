{{--
  layouts/register.blade.php
  ==========================
  Master layout untuk alur registrasi multi-langkah (Onboarding Flow):
  1. Identitas Dasar (nama.blade.php)
  2. Program Studi (prodi.blade.php)
  3. Minat Belajar (minat.blade.php)
  4. Domisili (domisili.blade.php)
  5. Keamanan Password (password.blade.php)

  Slot / Sections:
    - title        : Judul tab browser
    - progress     : Persentase progress bar (cth: '20%', '40%', '60%', '80%', '100%')
    - back-url     : URL navigasi mundur (cth: '/', '/prodi', '/minat', dll)
    - page-style   : Variabel CSS khusus gradien (--grad-top, --grad-bottom)
    - track-style  : Variabel CSS track progress (--track)
    - main-attrs   : Atribut inline tambahan untuk <main class="reg-main">
    - content      : Formulir dan konten langkah registrasi
--}}
@extends('layouts.base')

@section('body')
  <div class="reg-page" style="@yield('page-style', '--grad-top: #cce5ff')">
    <header class="reg-header" style="@yield('track-style', '--track: #ffffff')">
      <div class="reg-progress">
        <span style="width: @yield('progress', '20%')"></span>
      </div>
      <div class="reg-bar">
        <a class="reg-back" href="@yield('back-url', '/')" aria-label="Kembali">
          <img src="{{ asset('image/d0a89.svg') }}" width="13.3333" height="13.3333" alt="" />
        </a>
        <a class="reg-brand" href="/">
          <span class="reg-logo"><img src="{{ asset('image/e26aa.png') }}" alt="" /></span>
          <span class="reg-brand-name is-bold">StudyMate</span>
        </a>
      </div>
    </header>

    <main class="reg-main" @yield('main-attrs')>
      @yield('content')
    </main>
  </div>
@endsection
