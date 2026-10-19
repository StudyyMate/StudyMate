{{--
  layouts/auth.blade.php
  ======================
  Layout untuk halaman autentikasi dan onboarding awal:
  - Welcome Screen (index.blade.php)
  - Login (login.blade.php)
  
  Mewarisi layouts/base.blade.php tanpa topbar dan nav aplikasi.
--}}
@extends('layouts.base')

@section('body')
  @yield('content')
@endsection
