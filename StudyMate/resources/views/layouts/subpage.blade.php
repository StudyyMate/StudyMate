{{--
  layouts/subpage.blade.php
  =========================
  Layout untuk halaman fitur internal bertingkat (Materi, Kuis):
  Menyediakan sub-top bar dengan tombol kembali, judul fitur, dan tombol avatar profil.
--}}
@extends('layouts.base')

@section('body')
  <div class="sub-page @yield('subpage-class')" @yield('subpage-attrs')>
    <header class="sub-top">
      <div class="sub-wrap" @yield('subwrap-attrs')>
        <div class="sub-top-left" @yield('subtop-left-attrs')>
          <a class="sub-back" href="@yield('back-url', '/jadwal')" aria-label="Kembali">
            <img src="{{ asset('image/6fe11.svg') }}" width="16" height="16" alt="" />
          </a>
          <div>
            <h1 class="sub-title pj-semi" @yield('subtitle-attrs')>@yield('page-title')</h1>
            @hasSection('page-caption')
              <p class="sub-caption in-reg">@yield('page-caption')</p>
            @endif
          </div>
        </div>
        <a class="avatar-btn" href="/profil" aria-label="Profil">
          <img src="{{ asset('image/59e02.svg') }}" width="12" height="12" alt="" />
        </a>
      </div>
    </header>

    <main class="sub-wrap @yield('main-class')">
      @yield('content')
    </main>
  </div>
@endsection
