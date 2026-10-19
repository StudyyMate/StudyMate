{{--
  layouts/app.blade.php
  =====================
  Master layout untuk seluruh halaman utama aplikasi StudyMate:
  Dashboard, Chat, Jadwal, Profil, Cari, Hasil.
  
  Mewarisi layouts/base.blade.php dan menambahkan:
    - Wrapper .dash @yield('page-class')
    - Header topbar bersama (@include('components.topbar'))
    - Container <main class="wrap @yield('main-class')">
    - Bottom navigation bersama (@include('layouts.nav'))
--}}
@extends('layouts.base')

@section('body')
  <div class="dash @yield('page-class')">

    {{-- Topbar Bersama --}}
    @include('components.topbar')

    {{-- Konten Utama Halaman --}}
    <main class="wrap @yield('main-class')">
      @yield('content')
    </main>

    {{-- Bottom Navigation Bersama --}}
    @include('layouts.nav')

  </div>

  @yield('page-scripts')
@endsection
