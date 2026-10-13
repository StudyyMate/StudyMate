<!doctype html>
<html lang="id">
  @include('layouts.head')
  <body>
    <div class="reg-page" data-node-id="9:318" style="--grad-top: #cce4fd">
    <header class="reg-header" style="--track: #e2e7ff">
      <div class="reg-progress"><span style="width: 80%"></span></div>
      <div class="reg-bar">
        <a class="reg-back" href="/register/minat.html" aria-label="Kembali"><img src="{{asset("image/d0a89.svg")}}" width="13.3333" height="13.3333" alt="" /></a>
        <a class="reg-brand" href="/">
          <span class="reg-logo"><img src="{{ asset("image/e26aa.png")}}" alt="" /></span>
          <span class="reg-brand-name">StudyMate</span>
        </a>
      </div>
    </header>
      <main class="reg-main">
        <div class="reg-step" style="padding-bottom:12px">
          <span class="f-semibold" style="color:#408bc9;letter-spacing:1.1px">LANGKAH 04 / 05</span>
          <span class="dot" style="width:6px;height:6px;background:#c3c0ff"></span>
          <span class="f-medium" style="color:#464555;letter-spacing:0.66px">Wilayah &amp; Zona Waktu</span>
        </div>
        <h1 class="reg-title">Di mana lokasi domisili Anda?</h1>
        <p class="reg-lead" style="margin-bottom:32px">Untuk menghubungkan Anda dengan study group terdekat dan penyesuaian zona waktu.</p>
        <form class="reg-form" style="gap:20px" action="/password">
          <div class="field" style="gap:6px">
            <div class="field-label"><label class="label f-medium" for="provinsi">Provinsi</label><span class="hint">Wajib diisi</span></div>
            <div class="select-wrap">
              <select class="select" id="provinsi" name="provinsi" required>
                <option>Jawa Timur</option><option>Jawa Tengah</option><option>Jawa Barat</option><option>DKI Jakarta</option><option>DI Yogyakarta</option><option>Bali</option>
              </select>
              <img src="{{asset("image/ab41e.svg")}}" width="10" height="6.16667" alt="" />
            </div>
          </div>
          <div class="field" style="gap:6px">
            <div class="field-label"><label class="label f-medium" for="kota">Kota</label><span class="hint f-medium">Wajib diisi</span></div>
            <div class="select-wrap">
              <select class="select" id="kota" name="kota" required>
                <option>Surabaya</option><option>Malang</option><option>Sidoarjo</option><option>Kediri</option><option>Jember</option>
              </select>
              <img src="{{asset("image/ab41e.svg")}}" width="10" height="6.16667" alt="" />
            </div>
          </div>
          <button class="cta r12" type="submit" style="gap:6px;margin-top:149px">Lanjut <img src="{{asset("image/03d99.svg")}}" width="12" height="12" alt="" /></button>
        </form>
      </main>
    </div>
  </body>
</html>
