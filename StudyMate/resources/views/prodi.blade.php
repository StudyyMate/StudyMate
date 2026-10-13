<!doctype html>
<html lang="id">
  @include('layouts.head')
  <body>
    <div class="reg-page" data-node-id="9:143" style="--grad-top: #cde6ff">
    <header class="reg-header" style="--track: #ffffff">
      <div class="reg-progress"><span style="width: 40%"></span></div>
      <div class="reg-bar">
        <a class="reg-back" href="/register/nama.html" aria-label="Kembali"><img src="{{asset("image/d0a89.svg")}}" width="13.3333" height="13.3333" alt="" /></a>
        <a class="reg-brand" href="/">
          <span class="reg-logo"><img src="{{ asset("image/e26aa.png")}}" alt="" /></span>
          <span class="reg-brand-name">StudyMate</span>
        </a>
      </div>
    </header>
      <main class="reg-main">
        <div class="reg-step is-split">
          <div class="reg-step-group">
            <span class="f-semibold" style="color:#3525cd;letter-spacing:1.1px">LANGKAH 02</span>
            <span class="f-medium" style="color:#c7c4d8;letter-spacing:0.66px">/</span>
            <span class="f-medium" style="color:#464555;letter-spacing:0.55px">05 AKDEMIK</span>
          </div>
          <span class="f-medium" style="color:rgba(70,69,85,0.8);letter-spacing:0.66px">Estimasi 1 mnt</span>
        </div>
        <h1 class="reg-title">Pilih program studi Anda</h1>
        <p class="reg-lead">Membantu untuk menemukan teman yang relevan dengan program studi anda.</p>
        <form class="reg-form" action="/minat">
          <div class="field" style="gap:4px">
            <label class="label f-medium" for="prodi">Program Studi</label>
            <div class="input-wrap">
              <span class="input-icon"><img src="{{asset("image/94b7e.svg")}}" width="15" height="15" alt="" /></span>
              <input class="input has-icon is-search" id="prodi" name="prodi" type="search" placeholder="Cari atau ketik program studi" />
            </div>
          </div>
          <fieldset class="chip-group">
            <legend class="f-semibold">Jurusan</legend>
            <div class="chips f-medium">
              <label class="chip"><input type="radio" name="jurusan" value="teknik" /><span>Teknik &amp; Informatika</span></label>
              <label class="chip"><input type="radio" name="jurusan" value="ekonomi" /><span>Ekonomi &amp; Bisnis</span></label>
              <label class="chip"><input type="radio" name="jurusan" value="desain" /><span>Desain &amp; Media</span></label>
              <label class="chip"><input type="radio" name="jurusan" value="sains" /><span>Sains &amp; Kedokteran</span></label>
            </div>
          </fieldset>
          <button class="cta" type="submit" style="margin-top:72px">Lanjut <img src="{{asset("image/03d99.svg")}}" width="12" height="12" alt="" /></button>
        </form>
      </main>
    </div>
  </body>
</html>
