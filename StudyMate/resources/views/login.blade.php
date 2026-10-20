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

        @if ($errors->any())
          <div style="background:#ffdad8;color:#ad2f34;padding:12px 14px;border-radius:12px;font-size:13px;margin-bottom:16px">
            <ul style="margin:0;padding:0 0 0 16px">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form class="login-form" action="{{ route('login.post') }}" method="post" data-node-id="7:18">
          @csrf
          <div class="form-field">
            <label for="email">Email</label>
            <div class="input-shell">
              <img src="{{ asset('image/a208b.svg') }}" alt="" aria-hidden="true" />
              <input
                id="email"
                name="email"
                type="email"
                placeholder="nama@email.com"
                value="{{ old('email') }}"
                autocomplete="email"
                required
              />
            </div>
          </div>

          <div class="form-field password-field">
            <div class="field-heading">
              <label for="password">Password</label>
              <a href="#lupa-password">Lupa Password?</a>
            </div>
            <div class="input-shell">
              <img src="{{ asset('image/6a28e.svg') }}" alt="" aria-hidden="true" />
              <input
                id="password"
                name="password"
                type="password"
                placeholder="Masukkan password"
                autocomplete="current-password"
                required
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
        </script>
      </div>
    </section>

    <footer class="login-footer">
      <p>Belum punya akun? <a href="/register">Daftar</a></p>
      <div class="home-indicator-space" aria-hidden="true"></div>
    </footer>
  </main>
@endsection
