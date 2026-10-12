<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      name="description"
      content="Temukan teman belajar yang cocok denganmu bersama StudyMate."
    />
    <title>Selamat Datang ke StudyMate</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
  </head>
  <body>
    <main class="welcome-screen" data-node-id="1:2">
      <section class="welcome-content" aria-labelledby="welcome-heading">
        <div class="brand-block">
          <div class="logo-card" data-node-id="1:10">
            <img
              class="brand-logo"
              src="{{ asset("image/e26aa.png")}}"
              alt="StudyMate"
            />
          </div>

          <h1 id="welcome-heading" class="welcome-heading">
            Selamat Datang ke <span>StudyMate</span>
          </h1>
          <p class="welcome-copy">
            Temukan teman belajar yang cocok
            <br />
            denganmu.
          </p>
        </div>

        <nav class="welcome-actions" aria-label="Aksi akun">
          <a
            class="action-button action-button-primary"
            href="/register"
            data-node-id="1:22"
          >
            Daftar Akun Baru
          </a>
          <a
            class="action-button action-button-secondary"
            href="/login"
            data-node-id="1:26"
          >
            Sudah punya akun? Login
          </a>
        </nav>
      </section>
    </main>
  </body>
</html>
