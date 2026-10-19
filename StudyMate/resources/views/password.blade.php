@extends('layouts.register')

@section('title', 'Daftar - Buat Kata Sandi')
@section('progress', '100%')
@section('back-url', '/domisili')
@section('page-style', '--grad-top: #cde4fd')
@section('track-style', '--track: #e2e7ff')

@section('content')
  <div class="reg-step is-split" style="padding-bottom:24px">
    <span class="f-semibold" style="color:#777587;font-size:12px;line-height:16px;letter-spacing:0.6px">05 / 05 — KEAMANAN</span>
    <span class="pill f-medium" style="padding:4px 10px;color:#464555;letter-spacing:0.66px">
      <img src="{{ asset('image/20a40.svg') }}" width="9.33333" height="12.25" alt="" />Enkripsi 256-bit
    </span>
  </div>
  <h1 class="reg-title">Buat kata sandi akun</h1>
  <p class="reg-lead" style="line-height:24px">Pastikan minimal 8 karakter dengan kombinasi huruf dan angka.</p>

  <form class="reg-form" action="/dashboard" method="get">
    <div class="field">
      <div class="field-label f-medium">
        <label class="label" for="pw">Password</label>
        <span class="hint" style="color:#777587">Kekuatan: Kuat</span>
      </div>
      <div class="input-wrap">
        <input class="input r12" id="pw" name="password" type="password" placeholder="••••••••••••" minlength="8" autocomplete="new-password" required />
        <button class="eye" type="button" aria-label="Tampilkan password">
          <img src="{{ asset('image/dbb07.svg') }}" width="18.3333" height="12.5" alt="" />
        </button>
      </div>
      <div class="strength">
        <div class="strength-bars" aria-hidden="true"><span></span><span></span><span></span><span></span></div>
        <p class="strength-text f-medium">
          <img src="{{ asset('image/26085.svg') }}" width="10.8333" height="10.8333" alt="" />Minimal 8 karakter
        </p>
      </div>
    </div>

    <div class="field">
      <label class="label f-medium" for="pw2">Konfirmasi Password</label>
      <div class="input-wrap">
        <input class="input r12" id="pw2" name="password_confirm" type="password" placeholder="••••••••••••" minlength="8" autocomplete="new-password" required />
        <button class="eye" type="button" aria-label="Tampilkan password">
          <img src="{{ asset('image/dbb07.svg') }}" width="18.3333" height="12.5" alt="" />
        </button>
      </div>
    </div>

    <label class="agree">
      <input type="checkbox" name="agree" required />
      <span class="box"><img src="{{ asset('image/7f654.svg') }}" width="32" height="32" alt="" /></span>
      <span>Saya menyetujui <a class="f-medium" href="#">Ketentuan Layanan</a> &amp;<br /><a class="f-medium" href="#">Kebijakan Privasi</a></span>
    </label>

    <button class="cta r12" type="submit">
      Daftar <img src="{{ asset('image/03d99.svg') }}" width="12" height="12" alt="" />
    </button>
  </form>
@endsection
