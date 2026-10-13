<!doctype html>
<html lang="id">
  @include('layouts.head')
  <body>
    <div class="dash jadwal-page" data-node-id="18:391">
      <header class="topbar">
        <div class="wrap">
          <a class="brand" href="/dashboard.html"><span class="logo"><img src="{{asset("image/e26aa.png")}}" alt="" /></span><span class="brand-name pj-bold">StudyMate</span></a>
          <div class="top-actions">
            <a class="icon-btn" href="#notifikasi" aria-label="Notifikasi"><img src="{{asset("image/7cf12.svg")}}" width="14.6667" height="18.3333" alt="" /><span class="notif-dot"></span></a>
            <a class="icon-btn" href="#profil" aria-label="Profil"><span class="avatar-btn"><img src="{{asset("image/59e02.svg")}}" width="12" height="12" alt="" /></span></a>
          </div>
        </div>
      </header>

      <main class="wrap jd-main">
        <div class="jd-intro">
          <div class="jd-eyebrow-row">
            <span class="jd-eyebrow pj-bold">Rencana Belajarmu</span>
            <span class="jd-reminder-pill pj-bold"><img src="{{asset("image/0a5b3.svg")}}" width="12.5" height="12.5" alt="" />1 pengingat H-1 aktif</span>
          </div>
          <h1 class="jd-title pj-xbold">Jadwal Belajar</h1>
          <p class="jd-lead in-reg">Atur sesi belajar, pantau undangan, dan bersiap tepat waktu bersama teman belajarmu.</p>
        </div>

        <section class="jd-alert" aria-label="Pengingat H-1">
          <div class="jd-alert-top">
            <div class="jd-alert-main">
              <span class="jd-bell"><img src="{{asset("image/8d5a3.svg")}}" width="16.6667" height="16.7083" alt="" /></span>
              <div><p class="jd-alert-kicker pj-bold">Pengingat H-1</p><p class="jd-alert-title pj-bold">Besok, belajar SQL bersama Utami Putri</p></div>
            </div>
            <span class="jd-active pj-bold">Aktif</span>
          </div>
          <p class="jd-alert-date in-med"><img src="{{asset("image/c51e2.svg")}}" width="12" height="13.3333" alt="" />Minggu, 04 Oktober 2026 • 10.00–11.30</p>
        </section>

        <section aria-labelledby="sesi" style="display:flex;flex-direction:column;gap:8px">
          <div class="jd-sec-head">
            <div><h2 id="sesi" class="jd-h2 pj-bold">Sesi Terjadwal</h2><p class="jd-sub in-reg">2 sesi belajar mendatang</p></div>
            <a class="jd-link pj-semi" href="#kalender">Lihat kalender <img src="{{asset("image/0bfd0.svg")}}" width="4.93333" height="8" alt="" /></a>
          </div>
          <ul class="jd-sessions">
          <li class="session">
            <div class="session-top">
              <div class="date-box"><span class="m pj-bold">OKT</span><span class="d pj-xbold">04</span><span class="w pj-semi">Minggu</span></div>
              <div class="session-info">
                <p class="partner pj-bold"><span class="initials">UP</span>Utami Putri</p>
                <h3 class="jd-h2 pj-bold" style="margin:0">Latihan query SQL</h3>
                <p class="session-meta in-reg"><span><img src="{{asset("image/700b6.svg")}}" width="10.5" height="11.6667" alt="" />04 Oktober 2026</span>•<span><img src="{{asset("image/ece93.svg")}}" width="11.6667" height="11.6667" alt="" />10.00–11.30</span></p>
              </div>
            </div>
            <div class="session-actions pj-semi">
              <label class="up-btn"><input type="file" accept="image/*" /><img src="{{asset("image/e2d71.svg")}}" width="15" height="13.5" alt="" />Upload Foto</label>
              <label class="up-btn solid"><input type="file" /><img src="{{asset("image/87493.svg")}}" width="12" height="15" alt="" />Upload Materi</label>
            </div>
          </li>
          <li class="session">
            <div class="session-top">
              <div class="date-box"><span class="m pj-bold">OKT</span><span class="d pj-xbold">12</span><span class="w pj-semi">Senin</span></div>
              <div class="session-info">
                <p class="partner pj-bold"><span class="initials">TA</span>Talitha Ameliya</p>
                <h3 class="jd-h2 pj-bold" style="margin:0">Genetic Algorithn</h3>
                <p class="session-meta in-reg"><span><img src="{{asset("image/700b6.svg")}}" width="10.5" height="11.6667" alt="" />12 Oktober 2026</span>•<span><img src="{{asset("image/ece93.svg")}}" width="11.6667" height="11.6667" alt="" />18.00-20.00</span></p>
              </div>
            </div>
            <div class="session-actions pj-semi">
              <label class="up-btn"><input type="file" accept="image/*" /><img src="{{asset("image/e2d71.svg")}}" width="15" height="13.5" alt="" />Upload Foto</label>
              <label class="up-btn solid"><input type="file" /><img src="{{asset("image/87493.svg")}}" width="12" height="15" alt="" />Upload Materi</label>
            </div>
          </li>
          </ul>
        </section>

        <form class="jd-form" action="#">
          <div class="jd-form-head">
            <span class="jd-form-icon"><img src="{{asset("image/ba8b6.svg")}}" width="17.4167" height="18.3333" alt="" /></span>
            <div><h2 class="jd-h2 pj-bold">Buat Jadwal</h2><p class="jd-sub in-reg">Kirim undangan sesi baru ke teman belajarmu.</p></div>
          </div>
          <div class="jd-fields">
            <div class="jd-field">
              <label class="jd-label pj-semi" for="teman">Pilih Teman</label>
              <div class="jd-control"><span class="lead-ico"><img src="{{asset("image/d24b1.svg")}}" width="13.3333" height="13.3333" alt="" /></span>
                <select class="jd-input" id="teman" name="teman"><option>Nadia Omara</option><option>Utami Putri</option><option>Talitha Ameliya</option><option>Anashtasya Aulia</option><option>Fairuzzahwa</option><option>Zainul Fikri</option></select><img class="chev" src="{{asset("image/71a7f.svg")}}" width="10" height="6.16667" alt="" /></div>
            </div>
            <div class="jd-field">
              <label class="jd-label pj-semi" for="tanggal">Tanggal</label>
              <div class="jd-control"><span class="lead-ico"><img src="{{asset("image/808c7.svg")}}" width="15" height="16.6667" alt="" /></span>
                <input class="jd-input" id="tanggal" name="tanggal" type="text" value="10 Oktober 2026" /></div>
            </div>
            <div class="jd-field">
              <label class="jd-label pj-semi" for="hari">Hari</label>
              <div class="jd-control"><span class="lead-ico"><img src="{{asset("image/2326f.svg")}}" width="15" height="16.6667" alt="" /></span>
                <select class="jd-input" id="hari" name="hari"><option>Senin</option><option>Selasa</option><option>Rabu</option><option>Kamis</option><option>Jumat</option><option selected>Sabtu</option><option>Minggu</option></select><img class="chev" src="{{asset("image/71a7f.svg")}}" width="10" height="6.16667" alt="" /></div>
            </div>
            <div class="jd-field">
              <label class="jd-label pj-semi" for="waktu">Waktu</label>
              <div class="jd-control"><span class="lead-ico"><img src="{{asset("image/1e87f.svg")}}" width="16.6667" height="16.6667" alt="" /></span>
                <select class="jd-input" id="waktu" name="waktu"><option>07.00 – 08.30</option><option selected>09.00 – 10.30</option><option>13.00 – 14.30</option><option>16.00 – 17.30</option><option>19.00 – 20.30</option></select><img class="chev" src="{{asset("image/71a7f.svg")}}" width="10" height="6.16667" alt="" /></div>
            </div>
            <label class="jd-check">
              <input type="checkbox" name="pengingat" checked />
              <span class="box"><img src="{{asset("image/59a43.svg")}}" width="11.9333" height="9.1" alt="" /></span>
              <span><span class="jd-check-title pj-semi" style="display:block">Aktifkan  izin notifikasi pengingat H-1</span><span class="jd-check-sub in-reg">Notifikasi dikirim satu hari sebelum sesi.</span></span>
            </label>
          </div>
          <button class="jd-submit pj-bold" type="submit"><img src="{{asset("image/855f1.svg")}}" width="15" height="16.6667" alt="" />Simpan Jadwal</button>
        </form>
      </main>

    @include('layouts.nav')
    </div>
  </body>
</html>
