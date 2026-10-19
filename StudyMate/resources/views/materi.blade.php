@extends('layouts.subpage')

@section('title', 'Upload Materi Belajar')
@section('page-title', 'Upload Materi Belajar')
@section('page-caption', 'Bagikan catatan & ringkasan')
@section('back-url', '/jadwal')
@section('main-class', 'mt-main')

@section('content')
  <section class="mt-session">
    <div class="row-between">
      <span class="kicker pj-bold">
        <img src="{{ asset('image/e7cd5.svg') }}" width="14.6667" height="10.6667" alt="" />Sesi Belajar
      </span>
      <span class="partner-pill pj-bold">
        <span class="ini in-semi">NR</span>Nadia Rahma<span class="dot6"></span>
      </span>
    </div>
    <div class="row-between" style="align-items:flex-end">
      <div>
        <h2 class="mt-name pj-semi">Latihan Query SQL</h2>
        <p class="mt-date in-reg">
          <img src="{{ asset('image/9be1e.svg') }}" width="10.5" height="11.6667" alt="" />Minggu, 04 Okt &bull; 14:00 WIB
        </p>
      </div>
      <span class="modul pj-bold" style="margin-bottom:4px">
        <img src="{{ asset('image/49576.svg') }}" width="8.66667" height="10.8333" alt="" />Modul 4
      </span>
    </div>
  </section>

  <section class="mt-card">
    <div class="seg pj-semi" role="tablist">
      <button type="button" role="tab" aria-selected="true" data-accept=".pdf,.doc,.docx">
        <img src="{{ asset('image/6ba6a.svg') }}" width="12" height="15" alt="" />Dokumen (PDF, DOC)
      </button>
      <button type="button" role="tab" aria-selected="false" data-accept="image/*">
        <img src="{{ asset('image/ec6a1.svg') }}" width="15" height="16.5" alt="" />Pindai / Galeri
      </button>
    </div>

    <label class="drop" id="drop">
      <span class="glow1"></span><span class="glow2"></span>
      <span class="cloud"><img src="{{ asset('image/55feb.svg') }}" width="25.6667" height="18.6667" alt="" /></span>
      <h2 class="pj-semi">Tarik file ke sini atau ketuk layar</h2>
      <p class="in-reg">Mendukung berkas digital, modul kuliah, atau foto catatan tulisan tangan</p>
      <span class="formats pj-bold">
        <span class="fmt">PDF</span>
        <span class="fmt">DOCX</span>
        <span class="fmt max">Maks 5 MB</span>
      </span>
      <span class="pick pj-semi">
        <img src="{{ asset('image/eee2d.svg') }}" width="15" height="15" alt="" />Pilih File dari Perangkat
      </span>
      <input type="file" id="fileInput" accept=".pdf,.doc,.docx" hidden />
    </label>
  </section>

  <section class="file-card" id="fileCard">
    <div class="file-row">
      <div class="file-left">
        <span class="pdf-badge"><img src="{{ asset('image/3a46f.svg') }}" width="21.6667" height="21.6667" alt="" /></span>
        <div class="file-meta">
          <div class="file-name-row">
            <p class="file-name pj-semi" id="fName">Modul-04-SQL-Optimization.pdf</p>
            <span class="siap in-semi" id="fStatus">SIAP</span>
          </div>
          <p class="file-size in-reg" id="fSize">4.2 MB &bull; 24 Halaman</p>
        </div>
      </div>
      <div class="file-actions">
        <button type="button" aria-label="Lihat pratinjau" id="previewBtn">
          <img src="{{ asset('image/942ce.svg') }}" width="16" height="16" alt="" />
        </button>
        <button type="button" aria-label="Hapus dokumen" id="removeBtn">
          <img src="{{ asset('image/581c9.svg') }}" width="12" height="13.5" alt="" />
        </button>
      </div>
    </div>
    <div class="bar"><span id="fBar"></span></div>
    <div class="ai">
      <span class="ai-ico"><img src="{{ asset('image/28885.svg') }}" width="14.6667" height="14.6667" alt="" /></span>
      <p class="in-reg">
        <b class="pj-bold">AI StudyMate siap</b> mengekstrak 12 konsep query kunci dan membuat 8 kartu kuis kilat untuk sesi ini.
      </p>
    </div>
  </section>

  <div class="float-bar">
    <div class="sub-wrap">
      <div class="inner">
        <a class="quiz-btn pj-semi" href="/kuis" id="quizBtn">
          Kerjakan Kuis <img src="{{ asset('image/85d78.svg') }}" width="5.55" height="9" alt="" />
        </a>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    var input = document.getElementById('fileInput');
    var drop = document.getElementById('drop');
    var card = document.getElementById('fileCard');
    var quiz = document.getElementById('quizBtn');
    var bar = document.getElementById('fBar');
    var url = null;

    document.querySelectorAll('.seg button').forEach(function (b) {
      b.addEventListener('click', function () {
        document.querySelectorAll('.seg button').forEach(function (x) { x.setAttribute('aria-selected', String(x === b)); });
        input.accept = b.dataset.accept;
      });
    });

    function showFile(file) {
      if (file.size > 5 * 1024 * 1024) { alert('Ukuran file melebihi 5 MB.'); return; }
      if (url) URL.revokeObjectURL(url);
      url = URL.createObjectURL(file);
      document.getElementById('fName').textContent = file.name;
      document.getElementById('fSize').textContent = (file.size / 1048576).toFixed(1) + ' MB';
      var status = document.getElementById('fStatus');
      status.textContent = 'MENGUNGGAH';
      card.hidden = false; quiz.removeAttribute('aria-disabled');
      bar.style.transition = 'none'; bar.style.width = '0%';
      requestAnimationFrame(function () { bar.style.transition = ''; bar.style.width = '100%'; });
      setTimeout(function () { status.textContent = 'SIAP'; }, 650);
    }

    input.addEventListener('change', function () { if (input.files[0]) showFile(input.files[0]); input.value = ''; });
    ['dragenter', 'dragover'].forEach(function (ev) { drop.addEventListener(ev, function (e) { e.preventDefault(); drop.classList.add('over'); }); });
    ['dragleave', 'drop'].forEach(function (ev) { drop.addEventListener(ev, function (e) { e.preventDefault(); drop.classList.remove('over'); }); });
    drop.addEventListener('drop', function (e) { if (e.dataTransfer.files[0]) showFile(e.dataTransfer.files[0]); });

    document.getElementById('removeBtn').addEventListener('click', function () {
      card.hidden = true; quiz.setAttribute('aria-disabled', 'true');
      if (url) { URL.revokeObjectURL(url); url = null; }
    });
    document.getElementById('previewBtn').addEventListener('click', function () { if (url) window.open(url, '_blank'); });
  </script>
@endpush
