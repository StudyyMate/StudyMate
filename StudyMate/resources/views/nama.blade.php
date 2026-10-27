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

  {{-- Notif banner atas dihapus: pesan error langsung di masing-masing field --}}

  <form class="reg-form" action="{{ route('register.nama.store') }}" method="POST" novalidate>
    @csrf
    <div class="field">
      <div class="field-label">
        <label class="label f-medium" for="nama">Nama Lengkap</label>
        <span class="hint">Wajib diisi</span>
      </div>
      <input class="input @error('nama') is-invalid @enderror" id="nama" name="nama" type="text" placeholder="cth. Alex Pratama" autocomplete="name" value="{{ old('nama', session('register.nama')) }}" />
      <span class="field-error-msg" id="nama-error" style="display:{{ $errors->has('nama') ? 'block' : 'none' }}">{{ $errors->first('nama') ?: 'Data tidak boleh kosong.' }}</span>
    </div>

    <div class="field">
      <div class="field-label">
        <label class="label f-medium" for="email">Email</label>
        <span class="hint">Wajib diisi</span>
      </div>
      <input class="input @error('email') is-invalid @enderror" id="email" name="email" type="email" placeholder="cth. exyezet@gmail.com" autocomplete="email" value="{{ old('email', session('register.email')) }}" />
      <span class="field-error-msg" id="email-error" style="display:{{ $errors->has('email') ? 'block' : 'none' }}">{{ $errors->first('email') ?: 'Data tidak boleh kosong.' }}</span>
    </div>

    <div class="field">
      <div class="field-label">
        <label class="label f-medium" for="gender">Jenis Kelamin</label>
        <span class="hint">Wajib diisi</span>
      </div>
      <div class="select-wrap">
        <select class="select @error('gender') is-invalid @enderror" id="gender" name="gender">
          <option value="" disabled {{ old('gender', session('register.gender')) ? '' : 'selected' }}>Pilih jenis kelamin...</option>
          <option value="Laki-laki" {{ old('gender', session('register.gender')) === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
          <option value="Perempuan" {{ old('gender', session('register.gender')) === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
        </select>
        <img src="{{ asset('image/ab41e.svg') }}" width="10" height="6.16667" alt="" />
      </div>
      <span class="field-error-msg" id="gender-error" style="display:{{ $errors->has('gender') ? 'block' : 'none' }}">{{ $errors->first('gender') ?: 'Data tidak boleh kosong.' }}</span>
    </div>

    <div class="field">
      <div class="field-label f-medium">
        <label class="label" for="pw">Password</label>
        <span class="hint" style="color:#777587" id="strength-label">Kekuatan: —</span>
      </div>
      <div class="input-wrap">
        <input class="input r12 @error('password') is-invalid @enderror" id="pw" name="password" type="password" placeholder="••••••••••••" autocomplete="new-password" />
        <button class="eye" type="button" aria-label="Tampilkan password" data-target="pw">
          <img src="{{ asset('image/dbb07.svg') }}" width="18.3333" height="12.5" alt="" />
        </button>
      </div>
      <div class="strength">
        <div class="strength-bars" aria-hidden="true"><span></span><span></span><span></span><span></span></div>
        <p class="strength-text f-medium">
          <img src="{{ asset('image/26085.svg') }}" width="10.8333" height="10.8333" alt="" />Minimal 8 karakter, wajib mengandung angka dan simbol
        </p>
      </div>
      <span class="field-error-msg" id="pw-error" style="display:{{ $errors->has('password') ? 'block' : 'none' }}">{{ $errors->first('password') ?: 'Password tidak valid.' }}</span>
    </div>

    <div class="field">
      <label class="label f-medium" for="pw2">Konfirmasi Password</label>
      <div class="input-wrap">
        <input class="input r12 @error('password_confirmation') is-invalid @enderror" id="pw2" name="password_confirmation" type="password" placeholder="••••••••••••" autocomplete="new-password" />
        <button class="eye" type="button" aria-label="Tampilkan konfirmasi" data-target="pw2">
          <img src="{{ asset('image/dbb07.svg') }}" width="18.3333" height="12.5" alt="" />
        </button>
      </div>
      <span class="field-error-msg" id="pw2-error" style="display:none"></span>
    </div>

    
    <p class="note f-medium">
      <img src="{{ asset('image/01b40.svg') }}" width="10.6667" height="14" alt="" />
      Data Anda dienkripsi dan tidak pernah dibagikan kepada publik.
    </p>
    
    <div style="display:flex;flex-direction:column;gap:0">
      <label class="agree" id="agree-label">
        <input type="checkbox" id="agree" name="agree" />
        <span class="box"><img src="{{ asset('image/7f654.svg') }}" width="14" height="14" alt="" /></span>
        <span>Saya menyetujui <a class="f-medium" href="#">Ketentuan Layanan</a> &amp; <a class="f-medium" href="#">Kebijakan Privasi</a></span>
      </label>
      <span class="field-error-msg" id="agree-error" style="display:none">Data tidak boleh kosong.</span>
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

    // === Inline validation ===
    function showErr(input, errEl, msg) {
      input.classList.add('is-invalid');
      errEl.textContent = msg;
      errEl.style.display = 'block';
    }
    function clearErr(input, errEl) {
      input.classList.remove('is-invalid');
      errEl.style.display = 'none';
    }

    var namaInput  = document.getElementById('nama');
    var namaErr    = document.getElementById('nama-error');
    var emailInput = document.getElementById('email');
    var emailErr   = document.getElementById('email-error');
    var genderSel  = document.getElementById('gender');
    var genderErr  = document.getElementById('gender-error');
    var pwInput    = document.getElementById('pw');
    var pwErr      = document.getElementById('pw-error');
    var pw2Input   = document.getElementById('pw2');
    var pw2Err     = document.getElementById('pw2-error');

    // Nama
    namaInput.addEventListener('blur', function() {
      if (!namaInput.value.trim()) showErr(namaInput, namaErr, 'Data tidak boleh kosong.');
    });
    namaInput.addEventListener('input', function() {
      if (namaInput.value.trim()) clearErr(namaInput, namaErr);
    });

    // Email
    emailInput.addEventListener('blur', function() {
      var v = emailInput.value.trim();
      if (!v) {
        showErr(emailInput, emailErr, 'Data tidak boleh kosong.');
      }
    });
    emailInput.addEventListener('input', function() {
      if (emailInput.value.trim()) clearErr(emailInput, emailErr);
    });

    // Gender
    genderSel.addEventListener('change', function() {
      if (genderSel.value) clearErr(genderSel, genderErr);
    });

    // Password
    pwInput.addEventListener('blur', function() {
      var v = pwInput.value;
      if (!v) {
        showErr(pwInput, pwErr, 'Data tidak boleh kosong.');
      } else if (v.length < 8 || !/[0-9]/.test(v) || !/[\W_]/.test(v)) {
        showErr(pwInput, pwErr, 'Password tidak valid.');
      }
    });
    pwInput.addEventListener('input', function() {
      var v = pwInput.value;
      if (v.length >= 8 && /[0-9]/.test(v) && /[\W_]/.test(v)) clearErr(pwInput, pwErr);
      // juga cek konfirmasi jika sudah diisi
      if (pw2Input.value && pw2Input.value === v) clearErr(pw2Input, pw2Err);
    });

    // Konfirmasi Password
    pw2Input.addEventListener('blur', function() {
      if (!pw2Input.value) {
        showErr(pw2Input, pw2Err, 'Data tidak boleh kosong.');
      } else if (pw2Input.value !== pwInput.value) {
        showErr(pw2Input, pw2Err, 'Konfirmasi password tidak cocok.');
      }
    });
    pw2Input.addEventListener('input', function() {
      if (pw2Input.value && pw2Input.value === pwInput.value) clearErr(pw2Input, pw2Err);
    });

    // Agree checkbox
    var agreeCheck = document.getElementById('agree');
    var agreeLabel = document.getElementById('agree-label');
    var agreeErr   = document.getElementById('agree-error');
    agreeCheck.addEventListener('change', function() {
      if (agreeCheck.checked) {
        agreeLabel.classList.remove('is-invalid');
        agreeErr.style.display = 'none';
      }
    });

    // Submit: validasi semua field sebelum kirim ke server
    document.querySelector('form').addEventListener('submit', function(e) {
      var hasError = false;

      if (!namaInput.value.trim()) {
        showErr(namaInput, namaErr, 'Data tidak boleh kosong.');
        hasError = true;
      }
      if (!emailInput.value.trim()) {
        showErr(emailInput, emailErr, 'Data tidak boleh kosong.');
        hasError = true;
      }
      if (!genderSel.value) {
        showErr(genderSel, genderErr, 'Data tidak boleh kosong.');
        hasError = true;
      }
      var pwVal = pwInput.value;
      if (!pwVal) {
        showErr(pwInput, pwErr, 'Data tidak boleh kosong.');
        hasError = true;
      } else if (pwVal.length < 8 || !/[0-9]/.test(pwVal) || !/[\W_]/.test(pwVal)) {
        showErr(pwInput, pwErr, 'Password tidak valid.');
        hasError = true;
      }
      if (!pw2Input.value) {
        showErr(pw2Input, pw2Err, 'Data tidak boleh kosong.');
        hasError = true;
      } else if (pw2Input.value !== pwInput.value) {
        showErr(pw2Input, pw2Err, 'Konfirmasi password tidak cocok.');
        hasError = true;
      }
      if (!agreeCheck.checked) {
        agreeLabel.classList.add('is-invalid');
        agreeErr.style.display = 'block';
        hasError = true;
      }

      if (hasError) {
        e.preventDefault();
        // Scroll ke error pertama
        var firstErr = document.querySelector('.is-invalid');
        if (firstErr) firstErr.scrollIntoView({ behavior: 'smooth', block: 'center' });
      }
    });
  </script>
@endsection
