{{--
  layouts/base.blade.php
  ======================
  Base HTML5 shell untuk seluruh aplikasi StudyMate.
  Menyediakan:
    - HTML doctype & metadata
    - Google Fonts & Master CSS
    - Dynamic <title> via @yield('title')
    - Meta description via @yield('meta-description')
    - Stacks untuk CSS/JS khusus halaman: @stack('styles'), @stack('scripts')
--}}
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale() ?? 'id') }}">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() ?? '' }}" />
  <meta
    name="description"
    content="@yield('meta-description', 'StudyMate - Temukan teman belajar yang cocok denganmu.')"
  />
  <title>@yield('title', 'StudyMate') &ndash; StudyMate</title>

  {{-- Master Stylesheet --}}
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />

  {{-- Page-level custom styles --}}
  @stack('styles')
</head>
<body class="@yield('body-class')">

  {{-- Main Body Content --}}
  @yield('body')

  {{-- Page-level custom scripts --}}
  @stack('scripts')
</body>
</html>
