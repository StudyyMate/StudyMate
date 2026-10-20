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

  @if ($errors->any())
    <div style="background:#ffdad8;color:#ad2f34;padding:10px 14px;border-radius:8px;font-size:13px;margin-bottom:12px">
      <ul style="margin:0;padding:0 0 0 16px">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form class="reg-form" action="{{ route('register.nama.store') }}" method="POST">
    @csrf
    <div class="field">
      <div class="field-label">
        <label class="label f-medium" for="nama">Nama Lengkap</label>
        <span class="hint">Wajib diisi</span>
      </div>
      <input class="input" id="nama" name="nama" type="text" placeholder="cth. Alex Pratama" autocomplete="name" value="{{ old('nama', session('register.nama')) }}" required />
    </div>

    <div class="field">
      <div class="field-label">
        <label class="label f-medium" for="email">Email</label>
        <span class="hint">Wajib diisi</span>
      </div>
      <input class="input" id="email" name="email" type="email" placeholder="cth. exyezet@gmail.com" autocomplete="email" value="{{ old('email', session('register.email')) }}" required />
    </div>

    <div class="field">
      <div class="field-label">
        <label class="label f-medium" for="gender">Jenis Kelamin</label>
        <span class="hint">Wajib diisi</span>
      </div>
      <div class="select-wrap">
        <select class="select" id="gender" name="gender" required>
          <option value="" disabled {{ old('gender', session('register.gender')) ? '' : 'selected' }}>Pilih jenis kelamin...</option>
          <option value="Laki-laki" {{ old('gender', session('register.gender')) === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
          <option value="Perempuan" {{ old('gender', session('register.gender')) === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
        </select>
        <img src="{{ asset('image/ab41e.svg') }}" width="10" height="6.16667" alt="" />
      </div>
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
