<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      name="description"
      content="Masuk ke StudyMate dan temukan teman belajar yang cocok denganmu."
    />
    <title>Masuk ke StudyMate</title>
    <link rel="stylesheet" href={{ asset('css/style.css') }} />
  </head>
  <body>
    <main class="login-page" data-node-id="7:2">
      <div class="top-space" aria-hidden="true"></div>

      <section class="login-main" aria-labelledby="login-heading">
        <div class="login-stage">
          <header class="login-header" data-node-id="7:7">
            <div class="logo-space">
              <div class="logo-card" data-node-id="7:10">
                <img
                  class="brand-logo"
                  src="{{ asset("image/e26aa.png")}}"
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

          <form class="login-form" action="#" method="post" data-node-id="7:18">
            <div class="form-field">
              <label for="email">Email</label>
              <div class="input-shell">
                <img src="{{asset("svg/a208b.svg")}}" alt="" aria-hidden="true" />
                <input
                  id="email"
                  name="email"
                  type="email"
                  value="komangutami@gmail.com"
                  autocomplete="email"
                />
              </div>
            </div>

            <div class="form-field password-field">
              <div class="field-heading">
                <label for="password">Password</label>
                <a href="#lupa-password">Lupa Password?</a>
              </div>
              <div class="input-shell">
                <img src="{{asset("svg/6a28e.svg")}}" alt="" aria-hidden="true" />
                <input
                  id="password"
                  name="password"
                  type="text"
                  value="Informatika"
                  autocomplete="current-password"
                />
                <button
                  class="password-toggle"
                  type="button"
                  aria-label="Tampilkan password"
                >
                  <img src="{{asset("svg/994a5.svg")}}" alt="" aria-hidden="true" />
                </button>
              </div>
            </div>

            <button class="login-button" type="submit">
              <span>Login</span>
              <img src="{{asset("svg/03d99.svg")}}" alt="" aria-hidden="true" />
            </button>
          </form>
        </div>
      </section>

      <footer class="login-footer">
        <p>Belum punya akun? <a href="/register">Daftar</a></p>
        <div class="home-indicator-space" aria-hidden="true"></div>
      </footer>
    </main>
  </body>
</html>
