@extends('layouts.register')

@section('title', 'Daftar - Identitas Dasar')
@section('progress', '20%')
@section('back-url', '/')
@section('page-style', '--grad-top: #cce5ff')
@section('track-style', '--track: #ffffff')

@section('content')
  <div class="reg-step">
    <span class="f-medium" style="color:#464555;letter-spacing:1.1px;text-transform:uppercase">Langkah 01 / 05</span>
    <span class="dot"></span>
    <span class="f-semibold" style="color:#3525cd;letter-spacing:0.55px">Identitas Dasar</span>
  </div>
  <h1 class="reg-title">Siapa nama Anda?</h1>
  <p class="reg-lead">Gunakan nama lengkap atau nama panggilan yang ingin ditampilkan di profil.</p>

  <form class="reg-form" action="/prodi" method="get">
    <div class="field">
      <div class="field-label">
        <label class="label f-medium" for="nama">Nama Lengkap</label>
        <span class="hint">Wajib diisi</span>
      </div>
      <input class="input" id="nama" name="nama" type="text" placeholder="cth. Alex Pratama" autocomplete="name" required />
    </div>

    <div class="field">
      <div class="field-label">
        <label class="label f-medium" for="email">Email</label>
        <span class="hint">Wajib diisi</span>
      </div>
      <input class="input" id="email" name="email" type="email" placeholder="cth. exyezet@gmail.com" autocomplete="email" required />
    </div>

    <p class="note f-medium">
      <img src="{{ asset('image/01b40.svg') }}" width="10.6667" height="14" alt="" />
      Data Anda dienkripsi dan tidak pernah dibagikan kepada publik.
    </p>

    <button class="cta" type="submit" style="margin-top:16px">
      Lanjut <img src="{{ asset('image/03d99.svg') }}" width="12" height="12" alt="" />
    </button>
  </form>
@endsection
