<!doctype html>
<html lang="id">
  @include('layouts.head')
  <body>
    <div class="dash chat-page" data-node-id="16:291">
      <header class="topbar">
        <div class="wrap">
          <a class="brand" href="/dashboard.html"><span class="logo"><img src="{{asset("image/e26aa.png")}}" alt="" /></span><span class="brand-name pj-bold">StudyMate</span></a>
          <div class="top-actions">
            <a class="icon-btn" href="#notifikasi" aria-label="Notifikasi"><img src="{{asset("image/7cf12.svg")}}" width="14.6667" height="18.3333" alt="" /><span class="notif-dot"></span></a>
            <a class="icon-btn" href="#profil" aria-label="Profil"><span class="avatar-btn"><img src="{{asset("image/59e02.svg")}}" width="12" height="12" alt="" /></span></a>
          </div>
        </div>
      </header>

      <main class="wrap chat-main">
        <h1 class="chat-title pj-xbold">Chat</h1>
        <label class="search">
          <img src="{{asset("image/3bd7d.svg")}}" width="16" height="16" alt="" />
          <input type="search" name="q" placeholder="Cari teman..." aria-label="Cari teman" />
        </label>
        <ul class="threads">
          <li><a class="thread unread" href="#chat-utami-putri">
            <span class="av"><img src="{{asset("image/935bb.png")}}" class="cover" alt="" /></span>
            <div class="t-body">
              <p class="t-name pj-bold">Utami Putri</p>
              <p class="t-major pj-med">Informatika</p>
              <p class="t-meta pj-med">Surabaya  ·  Perempuan</p>
              <p class="t-msg pj-bold">Boleh, kita bahas besok besok ya!</p>
            </div>
            <div class="t-side"><span class="t-time pj-semi now">10.24</span><span class="t-dot" aria-label="Belum dibaca"></span></div>
          </a></li>
          <li><a class="thread unread" href="#chat-talitha-ameliya">
            <span class="av"><img src="{{asset("image/ebb50.png")}}" class="cover" alt="" /></span>
            <div class="t-body">
              <p class="t-name pj-bold">Talitha Ameliya</p>
              <p class="t-major pj-med">Informatika</p>
              <p class="t-meta pj-med">Surabaya  ·  Perempuan</p>
              <p class="t-msg pj-bold">Kabarin kalau besok kamu berangkat ya</p>
            </div>
            <div class="t-side"><span class="t-time pj-semi">09.15</span><span class="t-dot" aria-label="Belum dibaca"></span></div>
          </a></li>
          <li><a class="thread unread" href="#chat-anashtasya-aulia">
            <span class="av"><img src="{{asset("image/3c045.png")}}" style="left:0.15%;top:-21.37%;width:100%;height:177.54%" alt="" /></span>
            <div class="t-body">
              <p class="t-name pj-bold">Anashtasya Aulia</p>
              <p class="t-major pj-med">Informatika</p>
              <p class="t-meta pj-med">Yogyakarta  ·  Perempuan</p>
              <p class="t-msg pj-bold">Kapan-kapan main ke Jogja kita ketemu ya</p>
            </div>
            <div class="t-side"><span class="t-time pj-semi">Kemarin</span><span class="t-dot" aria-label="Belum dibaca"></span></div>
          </a></li>
          <li><a class="thread" href="#chat-fairuzzahwa">
            <span class="av"><img src="{{asset("image/1f2e8.png")}}" class="cover" alt="" /></span>
            <div class="t-body">
              <p class="t-name pj-bold">Fairuzzahwa</p>
              <p class="t-major pj-med">Statistika</p>
              <p class="t-meta pj-med">Bandung  ·  Perempuan</p>
              <p class="t-msg pj-med">Tuker materi aja, biar saling belajar</p>
            </div>
            <div class="t-side"><span class="t-time pj-semi">Sen</span></div>
          </a></li>
          <li><a class="thread" href="#chat-zainul-fikri">
            <span class="av"><img src="{{asset("image/8fb29.png")}}" class="cover" alt="" /></span>
            <div class="t-body">
              <p class="t-name pj-bold">Zainul Fikri</p>
              <p class="t-major pj-med">Informatika</p>
              <p class="t-meta pj-med">Surabaya  ·  Laki-laki</p>
              <p class="t-msg pj-med">Terima kasih, catatannya membantu banget</p>
            </div>
            <div class="t-side"><span class="t-time pj-semi">Min</span></div>
          </a></li>
        </ul>
      </main>
      @include('layouts.nav')
    </div>
  </body>
</html>
