@extends('layouts.base')

@section('title', 'Validasi Sesi Belajar')
@section('meta-description', 'Presensi dan validasi catatan belajar real-time StudyMate.')

@section('body')
  <div class="vs" data-node-id="37:308">
    <header class="vs-top">
      <div class="vs-wrap vs-top-in">
        <div class="vs-top-left">
          <a class="vs-close" href="/jadwal" aria-label="Tutup">
            <img src="{{ asset('image/ff7e8.svg') }}" width="12.8333" height="12.8333" alt="" />
          </a>
          <div>
            <h1 class="vs-title pj-bold">Validasi Sesi Akhir</h1>
            <p class="vs-subtitle in-reg"><span class="dot"></span>Presensi Belajar StudyMate</p>
          </div>
        </div>
        <span class="vs-chip pj-bold">
          <img src="{{ asset('image/e7446.svg') }}" width="9.33333" height="12.25" alt="" />Real-Time Only
        </span>
      </div>
    </header>

    <main class="vs-wrap vs-main">
      <section class="vs-banner">
        <span class="vs-banner-ico">
          <img src="{{ asset('image/cc842.svg') }}" width="12.6667" height="15.8333" alt="" />
        </span>
        <div>
          <h2 class="vs-banner-title pj-bold">Kamera Wajib Aktif</h2>
          <p class="vs-banner-text in-reg">Wajib ambil langsung dari kamera demi validasi kehadiran &amp; streak belajarmu.</p>
        </div>
      </section>

      <section class="vs-viewfinder" aria-label="Pratinjau kamera">
        <video id="video" class="vs-feed" autoplay playsinline muted></video>
        <canvas id="shot" class="vs-feed vs-shot" hidden></canvas>

        <div class="vs-vf-top">
          <span class="vs-live pj-bold" id="liveTag"><span class="dot"></span><span id="liveText">Kamera Aktif</span></span>
          <div class="vs-vf-controls">
            <button type="button" class="vs-round" id="flashBtn" aria-label="Flash" aria-pressed="false">
              <img src="{{ asset('image/c71ee.svg') }}" width="9" height="15" alt="" />
            </button>
            <button type="button" class="vs-round" id="flipBtn" aria-label="Ganti kamera">
              <img src="{{ asset('image/7f260.svg') }}" width="15" height="13.5" alt="" />
            </button>
          </div>
        </div>

        <div class="vs-guide" id="guide">
          <p class="vs-guide-title in-bold">
            <img src="{{ asset('image/80db2.svg') }}" width="16.5" height="12" alt="" />Area Catatan Belajar
          </p>
          <p class="vs-guide-sub in-reg">Pastikan tulisan terbaca jelas</p>
          <span class="cb tl"></span><span class="cb tr"></span><span class="cb bl"></span><span class="cb br"></span>
        </div>

        <div class="vs-vf-bottom">
          <span class="vs-af in-med"><span class="dot"></span>Auto-Focus Aktif</span>
        </div>
      </section>

      <section class="vs-controls">
        <div class="vs-shutter-row">
          <button type="button" class="vs-side" id="retakeBtn" aria-label="Ambil ulang">
            <img src="{{ asset('image/f629e.svg') }}" width="15" height="17.5" alt="" />
          </button>
          <div class="vs-shutter-wrap">
            <button type="button" class="vs-shutter" id="shutterBtn" aria-label="Ambil foto">
              <span class="vs-shutter-in">
                <img src="{{ asset('image/1071f.svg') }}" width="21.6667" height="19.5" alt="" />
              </span>
            </button>
            <p class="vs-hint in-med" id="hint">Ketuk untuk mengambil foto</p>
          </div>
          <button type="button" class="vs-side" id="helpBtn" aria-label="Bantuan">
            <img src="{{ asset('image/d0b46.svg') }}" width="16.6667" height="16.6667" alt="" />
          </button>
        </div>
        <div class="vs-action">
          <button type="button" class="vs-submit pj-bold" id="submitBtn" disabled>
            Verifikasi &amp; Selesaikan Sesi
            <img src="{{ asset('image/952d8.svg') }}" width="15.8333" height="15.8333" alt="" />
          </button>
        </div>
        <p class="vs-secure in-reg">
          <img src="{{ asset('image/44b78.svg') }}" width="11.9167" height="11.375" alt="" />
          Sistem Validasi Akademik Terintegrasi &bull; StudyMate
        </p>
      </section>
    </main>
  </div>
@endsection

@push('scripts')
  <script>
    var video = document.getElementById('video');
    var canvas = document.getElementById('shot');
    var hint = document.getElementById('hint');
    var submit = document.getElementById('submitBtn');
    var liveText = document.getElementById('liveText');
    var liveTag = document.getElementById('liveTag');
    var facing = 'environment';
    var stream = null;
    var captured = false;

    function setHint(t) { hint.textContent = t; }

    function startCamera() {
      if (stream) stream.getTracks().forEach(function (t) { t.stop(); });
      if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        setHint('Kamera tidak didukung di perangkat ini');
        liveTag.classList.add('off'); liveText.textContent = 'Kamera Nonaktif';
        return;
      }
      navigator.mediaDevices.getUserMedia({ video: { facingMode: facing }, audio: false })
        .then(function (s) {
          stream = s; video.srcObject = s;
          liveTag.classList.remove('off'); liveText.textContent = 'Kamera Aktif';
          if (!captured) setHint('Ketuk untuk mengambil foto');
        })
        .catch(function () {
          liveTag.classList.add('off'); liveText.textContent = 'Kamera Nonaktif';
          setHint('Izinkan akses kamera untuk melanjutkan');
        });
    }

    document.getElementById('shutterBtn').addEventListener('click', function () {
      if (!video.videoWidth) { setHint('Kamera belum siap'); return; }
      canvas.width = video.videoWidth; canvas.height = video.videoHeight;
      canvas.getContext('2d').drawImage(video, 0, 0);
      canvas.hidden = false; captured = true; submit.disabled = false;
      setHint('Foto diambil. Ketuk ulang untuk mengganti');
    });

    document.getElementById('retakeBtn').addEventListener('click', function () {
      canvas.hidden = true; captured = false; submit.disabled = true;
      setHint('Ketuk untuk mengambil foto');
    });

    document.getElementById('flipBtn').addEventListener('click', function () {
      facing = facing === 'environment' ? 'user' : 'environment';
      startCamera();
    });

    document.getElementById('flashBtn').addEventListener('click', function () {
      var btn = this;
      var on = btn.getAttribute('aria-pressed') !== 'true';
      var track = stream && stream.getVideoTracks()[0];
      if (track && track.applyConstraints) track.applyConstraints({ advanced: [{ torch: on }] }).catch(function () {});
      btn.setAttribute('aria-pressed', String(on));
    });

    document.getElementById('helpBtn').addEventListener('click', function () {
      setHint('Arahkan catatan belajarmu ke dalam kotak, lalu ketuk tombol kamera');
    });

    submit.addEventListener('click', function () {
      if (!captured) return;
      if (stream) stream.getTracks().forEach(function (t) { t.stop(); });
      submit.disabled = true;
      submit.firstChild.textContent = 'Sesi Terverifikasi ';
      setTimeout(function () { window.location.href = '/jadwal'; }, 900);
    });

    startCamera();
  </script>
@endpush
