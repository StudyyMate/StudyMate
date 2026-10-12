<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Identitas Dasar · StudyMate</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
  </head>
  <body>
    <div class="reg-page" data-node-id="9:80" style="--grad-top: #cce5ff">
    <header class="reg-header" style="--track: #ffffff">
      <div class="reg-progress"><span style="width: 20%"></span></div>
      <div class="reg-bar">
        <a class="reg-back" href="/" aria-label="Kembali"><img src="{{asset("svg/d0a89.svg")}}" width="13.3333" height="13.3333" alt="" /></a>
        <a class="reg-brand" href="/">
          <span class="reg-logo"><img src="{{ asset("image/e26aa.png")}}" alt="" /></span>
          <span class="reg-brand-name is-bold">StudyMate</span>
        </a>
      </div>
    </header>
      <main class="reg-main">
        <div class="reg-step">
          <span class="f-medium" style="color:#464555;letter-spacing:1.1px;text-transform:uppercase">Langkah 01 / 04</span>
          <span class="dot"></span>
          <span class="f-semibold" style="color:#3525cd;letter-spacing:0.55px">Identitas Dasar</span>
        </div>
        <h1 class="reg-title">Siapa nama Anda?</h1>
        <p class="reg-lead">Gunakan nama lengkap atau nama panggilan yang ingin ditampilkan di profil.</p>
        <form class="reg-form" action="/prodi">
          <div class="field">
            <div class="field-label"><label class="label f-medium" for="nama">Nama Lengkap</label><span class="hint">Wajib diisi</span></div>
            <input class="input" id="nama" name="nama" type="text" placeholder="cth. Alex Pratama" autocomplete="name" required />
          </div>
          <div class="field">
            <div class="field-label"><label class="label f-medium" for="email">Email</label><span class="hint">Wajib diisi</span></div>
            <input class="input" id="email" name="email" type="email" placeholder="cth. exyezet@gmail.com" autocomplete="email" required />
          </div>
          <p class="note f-medium"><img src="{{asset("svg/01b40.svg")}}" width="10.6667" height="14" alt="" />Data Anda dienkripsi dan tidak pernah dibagikan kepada publik.</p>
          <button class="cta" type="submit" style="margin-top:16px">Lanjut <img src="{{asset("svg/03d99.svg")}}" width="12" height="12" alt="" /></button>
        </form>
      </main>
    </div>
  </body>
</html>
