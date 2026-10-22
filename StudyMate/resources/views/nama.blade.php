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

    <div class="field">
      <div class="field-label f-medium">
        <label class="label" for="pw">Password</label>
        <span class="hint" style="color:#777587" id="strength-label">Kekuatan: —</span>
      </div>
      <div class="input-wrap">
        <input class="input r12" id="pw" name="password" type="password" placeholder="••••••••••••" minlength="8" autocomplete="new-password" required />
        <button class="eye" type="button" aria-label="Tampilkan password" data-target="pw">
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
        <input class="input r12" id="pw2" name="password_confirmation" type="password" placeholder="••••••••••••" minlength="8" autocomplete="new-password" required />
        <button class="eye" type="button" aria-label="Tampilkan konfirmasi" data-target="pw2">
          <img src="{{ asset('image/dbb07.svg') }}" width="18.3333" height="12.5" alt="" />
        </button>
      </div>
    </div>

    
    <p class="note f-medium">
      <img src="{{ asset('image/01b40.svg') }}" width="10.6667" height="14" alt="" />
      Data Anda dienkripsi dan tidak pernah dibagikan kepada publik.
    </p>
    
    <div style="display:flex;flex-direction:column;gap:0">
      <label class="agree">
        <input type="checkbox" name="agree" required />
        <span class="box"><img src="{{ asset('image/7f654.svg') }}" width="12" height="12" alt="" /></span>
        <span>Saya menyetujui <a class="f-medium" href="#">Ketentuan Layanan</a> &amp; <a class="f-medium" href="#">Kebijakan Privasi</a></span>
      </label>
    </div>

    <button class="cta" type="submit" style="margin-top:16px">
      Lanjut <img src="{{ asset('image/03d99.svg') }}" width="12" height="12" alt="" />
    </button>
  </form>

  <script>
    // Eye toggle
    document.querySelectorAll('.eye[data-target]').forEach(function(btn) {
      btn.addEventListener('click', function() {
        var inp = document.getElementById(btn.dataset.target);
        inp.type = inp.type === 'password' ? 'text' : 'password';
      });
    });

    // Password strength
    var pw = document.getElementById('pw');
    var bars = document.querySelectorAll('.strength-bars span');
    var label = document.getElementById('strength-label');
    pw.addEventListener('input', function() {
      var v = pw.value;
      var score = 0;
      if (v.length >= 8) score++;
      if (/[A-Z]/.test(v)) score++;
      if (/[0-9]/.test(v)) score++;
      if (/[^A-Za-z0-9]/.test(v)) score++;
      var colors = ['#ad2f34','#f59e0b','#10b981','#10b981'];
      var labels = ['Lemah','Cukup','Kuat','Sangat Kuat'];
      bars.forEach(function(b, i) {
        b.style.background = i < score ? colors[score - 1] : '#dae2fd';
      });
      label.textContent = v.length ? 'Kekuatan: ' + labels[score - 1] : 'Kekuatan: —';
    });
  </script>
@endsection
