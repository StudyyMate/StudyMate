@extends('layouts.auth')

@section('title', 'Masuk ke StudyMate')
@section('meta-description', 'Masuk ke akun StudyMate Anda untuk mulai mencari teman belajar.')

@section('content')
  <main class="login-page" data-node-id="7:2">
    <div class="top-space" aria-hidden="true"></div>

    <section class="login-main" aria-labelledby="login-heading">
      <div class="login-stage">
        <header class="login-header" data-node-id="7:7">
          <div class="logo-space">
            <div class="logo-card" data-node-id="7:10">
              <img
                class="brand-logo"
                src="{{ asset('image/e26aa.png') }}"
                alt="StudyMate"
              />
            </div>
          </div>

          <h1 id="login-heading" class="login-heading">
            Masuk ke <span>StudyMate</span>
          </h1>
          <p class="login-copy">
            Temukan teman belajar yang cocok
            <br />
            denganmu.
          </p>
        </header>

        @if (session('success'))
          <div style="background:#d4edda;color:#155724;padding:12px 14px;border-radius:12px;font-size:13px;margin-bottom:16px">
            {{ session('success') }}
          </div>
        @endif

        @if (session('info'))
          <div style="background:#d1ecf1;color:#0c5460;padding:12px 14px;border-radius:12px;font-size:13px;margin-bottom:16px">
            {{ session('info') }}
          </div>
        @endif

        <form class="login-form" id="login-form" action="{{ route('login.post') }}" method="post" data-node-id="7:18" novalidate>
          @csrf
          <div class="form-field">
            <label for="email">Email</label>
            <div class="input-shell {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email-shell">
              <img src="{{ asset('image/a208b.svg') }}" alt="" aria-hidden="true" />
              <input
                id="email"
                name="email"
                type="text"
                placeholder="nama@email.com"
                value="{{ old('email') }}"
                autocomplete="email"
              />
            </div>
            <div class="field-error-msg" id="email-error" style="display: {{ $errors->has('email') ? 'block' : 'none' }}">
              {{ $errors->first('email') }}
            </div>
          </div>

          <div class="form-field password-field">
            <div class="field-heading">
              <label for="password">Password</label>
              <a href="#lupa-password">Lupa Password?</a>
            </div>
            <div class="input-shell {{ $errors->has('password') ? 'is-invalid' : '' }}" id="password-shell">
              <img src="{{ asset('image/6a28e.svg') }}" alt="" aria-hidden="true" />
              <input
                id="password"
                name="password"
                type="password"
                placeholder="Masukkan password"
                autocomplete="current-password"
              />
              <button
                class="password-toggle"
                id="password-toggle"
                type="button"
                aria-label="Tampilkan password"
              >
                <img src="{{ asset('image/994a5.svg') }}" alt="" aria-hidden="true" />
              </button>
            </div>
            <div class="field-error-msg" id="password-error" style="display: {{ $errors->has('password') ? 'block' : 'none' }}">
              {{ $errors->first('password') }}
            </div>
          </div>

          <button class="login-button" type="submit">
            <span>Login</span>
            <img src="{{ asset('image/03d99.svg') }}" alt="" aria-hidden="true" />
          </button>
        </form>

        <script>
          var toggleBtn = document.getElementById('password-toggle');
          var passInput = document.getElementById('password');

          if (toggleBtn && passInput) {
            toggleBtn.addEventListener('click', function() {
              if (passInput.type === 'password') {
                passInput.type = 'text';
                this.setAttribute('aria-label', 'Sembunyikan password');
              } else {
                passInput.type = 'password';
                this.setAttribute('aria-label', 'Tampilkan password');
              }
            });
          }

          // Inline validation
          var loginForm = document.getElementById('login-form');
          var emailInput = document.getElementById('email');
          var emailShell = document.getElementById('email-shell');
          var emailError = document.getElementById('email-error');
          var passShell = document.getElementById('password-shell');
          var passError = document.getElementById('password-error');

          function setError(shell, errorEl, msg) {
            shell.classList.add('is-invalid');
            errorEl.textContent = msg;
            errorEl.style.display = 'block';
          }

          function clearError(shell, errorEl) {
            shell.classList.remove('is-invalid');
            errorEl.textContent = '';
            errorEl.style.display = 'none';
          }

          emailInput.addEventListener('blur', function() {
            if (!this.value.trim()) {
              setError(emailShell, emailError, 'Data tidak boleh kosong.');
            }
          });

          emailInput.addEventListener('input', function() {
            if (emailShell.classList.contains('is-invalid')) {
              clearError(emailShell, emailError);
            }
          });

          passInput.addEventListener('blur', function() {
            if (!this.value) {
              setError(passShell, passError, 'Data tidak boleh kosong.');
            }
          });

          passInput.addEventListener('input', function() {
            if (passShell.classList.contains('is-invalid')) {
              clearError(passShell, passError);
            }
          });

          loginForm.addEventListener('submit', function(e) {
            var valid = true;
            var firstInvalid = null;

            if (!emailInput.value.trim()) {
              setError(emailShell, emailError, 'Data tidak boleh kosong.');
              valid = false;
              if (!firstInvalid) firstInvalid = emailInput;
            }

            if (!passInput.value) {
              setError(passShell, passError, 'Data tidak boleh kosong.');
              valid = false;
              if (!firstInvalid) firstInvalid = passInput;
            }

            if (!valid) {
              e.preventDefault();
              if (firstInvalid) firstInvalid.focus();
            }
          });
        </script>
      </div>
    </section>

    <footer class="login-footer">
      <p>Belum punya akun? <a href="/register">Daftar</a></p>
      <div class="home-indicator-space" aria-hidden="true"></div>
    </footer>
  </main>
@endsection
