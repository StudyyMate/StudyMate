@extends('layouts.app')

@section('title', 'Hasil Pencarian Teman Belajar')
@section('main-class', 'cari-main hasil-main')

@section('content')
  <div class="intro tight">
    <h1 class="page-title pj-xbold">Hasil Pencarian</h1>
    <p class="page-lead pj-med">Menampilkan teman belajar yang sesuai dengan kriteriamu.</p>
  </div>
  <div class="chips" id="chips">
    <a class="chip pj-semi" href="/cari">Informatika</a>
  </div>

  <ul class="results" id="results">
    <li class="card" data-kota="Surabaya" data-gender="Perempuan" data-bidang="Database,SQL" data-prodi="Informatika">
      <div class="card-top">
        <span class="av-44"><img class="cover" src="{{ asset('image/935bb.png') }}" alt="" /></span>
        <div class="card-info">
          <p class="c-name pj-bold">Utami Putri</p>
          <p class="c-major pj-med">Informatika</p>
          <p class="c-meta pj-med">
            <span><img src="{{ asset('image/14c4a.svg') }}" width="11" height="11" alt="" />Surabaya</span>
            <span><img src="{{ asset('image/30868.svg') }}" width="11" height="11" alt="" />Perempuan</span>
          </p>
        </div>
      </div>
      <div class="card-foot">
        <div class="interests">
          <span class="interest pj-bold">Database</span>
          <span class="interest pj-bold">SQL</span>
        </div>
        <a class="chat-btn pj-bold" href="/chat-room?nama=Utami%20Putri">
          <img src="{{ asset('image/de1a9.svg') }}" width="11" height="11" alt="" />Chat
        </a>
      </div>
    </li>

    <li class="card" data-kota="Surabaya" data-gender="Perempuan" data-bidang="Python Algorithm,Computer Network" data-prodi="Informatika">
      <div class="card-top">
        <span class="av-44"><img class="cover" src="{{ asset('image/ebb50.png') }}" alt="" /></span>
        <div class="card-info">
          <p class="c-name pj-bold">Talitha Ameliya</p>
          <p class="c-major pj-med">Informatika</p>
          <p class="c-meta pj-med">
            <span><img src="{{ asset('image/14c4a.svg') }}" width="11" height="11" alt="" />Surabaya</span>
            <span><img src="{{ asset('image/30868.svg') }}" width="11" height="11" alt="" />Perempuan</span>
          </p>
        </div>
      </div>
      <div class="card-foot">
        <div class="interests">
          <span class="interest pj-bold">Python Algorithm</span>
          <span class="interest pj-bold">Computer Network</span>
        </div>
        <a class="chat-btn pj-bold" href="/chat-room?nama=Talitha%20Ameliya">
          <img src="{{ asset('image/de1a9.svg') }}" width="11" height="11" alt="" />Chat
        </a>
      </div>
    </li>

    <li class="card" data-kota="Lamongan" data-gender="Laki-laki" data-bidang="Web Dev,AI" data-prodi="Informatika">
      <div class="card-top">
        <span class="av-44"><img src="{{ asset('image/e93e1.png') }}" style="left:0.66%;top:-48.08%;width:100%;height:178.21%" alt="" /></span>
        <div class="card-info">
          <p class="c-name pj-bold">Sugeng</p>
          <p class="c-major pj-med">Informatika</p>
          <p class="c-meta pj-med">
            <span><img src="{{ asset('image/14c4a.svg') }}" width="11" height="11" alt="" />Lamongan</span>
            <span><img src="{{ asset('image/30868.svg') }}" width="11" height="11" alt="" />Laki-laki</span>
          </p>
        </div>
      </div>
      <div class="card-foot">
        <div class="interests">
          <span class="interest pj-bold">Web Dev</span>
          <span class="interest pj-bold">AI</span>
        </div>
        <a class="chat-btn pj-bold" href="/chat-room?nama=Sugeng">
          <img src="{{ asset('image/de1a9.svg') }}" width="11" height="11" alt="" />Chat
        </a>
      </div>
    </li>

    <li class="card" data-kota="Yogyakarta" data-gender="Perempuan" data-bidang="Cyber Security" data-prodi="Informatika">
      <div class="card-top">
        <span class="av-44"><img src="{{ asset('image/3c045.png') }}" style="left:0;top:-24.44%;width:100%;height:177.54%" alt="" /></span>
        <div class="card-info">
          <p class="c-name pj-bold">Anashtasya Aulia</p>
          <p class="c-major pj-med">Informatika</p>
          <p class="c-meta pj-med">
            <span><img src="{{ asset('image/14c4a.svg') }}" width="11" height="11" alt="" />Yogyakarta</span>
            <span><img src="{{ asset('image/30868.svg') }}" width="11" height="11" alt="" />Perempuan</span>
          </p>
        </div>
      </div>
      <div class="card-foot">
        <div class="interests">
          <span class="interest pj-bold">Cyber Security</span>
        </div>
        <a class="chat-btn pj-bold" href="/chat-room?nama=Anashtasya%20Aulia">
          <img src="{{ asset('image/de1a9.svg') }}" width="11" height="11" alt="" />Chat
        </a>
      </div>
    </li>

    <li class="card" data-kota="Denpasar" data-gender="Perempuan" data-bidang="UI/UX" data-prodi="Informatika">
      <div class="card-top">
        <span class="av-44"><img class="cover" src="{{ asset('image/0c0b6.png') }}" alt="" /></span>
        <div class="card-info">
          <p class="c-name pj-bold">Andin Nirwasita</p>
          <p class="c-major pj-med">Informatika</p>
          <p class="c-meta pj-med">
            <span><img src="{{ asset('image/14c4a.svg') }}" width="11" height="11" alt="" />Denpasar</span>
            <span><img src="{{ asset('image/30868.svg') }}" width="11" height="11" alt="" />Perempuan</span>
          </p>
        </div>
      </div>
      <div class="card-foot">
        <div class="interests">
          <span class="interest pj-bold">UI/UX</span>
        </div>
        <a class="chat-btn pj-bold" href="/chat-room?nama=Andin%20Nirwasita">
          <img src="{{ asset('image/de1a9.svg') }}" width="11" height="11" alt="" />Chat
        </a>
      </div>
    </li>
  </ul>

  <p class="empty pj-med" id="empty">Belum ada teman belajar yang cocok. <a href="/cari">Ubah kriteria pencarian</a></p>
@endsection

@push('scripts')
  <script>
    var params = new URLSearchParams(location.search);
    var f = { kota: params.get('kota'), gender: params.get('gender'), prodi: params.get('prodi'), bidang: params.get('bidang') };
    var active = Object.keys(f).filter(function (k) { return f[k]; });
    if (active.length) {
      document.getElementById('chips').innerHTML = active.map(function (k) {
        return '<a class="chip pj-semi" href="/cari">' + f[k].replace(/</g, '&lt;') + '</a>';
      }).join('');
    }
    var shown = 0;
    document.querySelectorAll('#results .card').forEach(function (card) {
      var ok = active.every(function (k) {
        return k === 'bidang' ? card.dataset.bidang.split(',').indexOf(f.bidang) > -1 : card.dataset[k] === f[k];
      });
      card.hidden = !ok; if (ok) shown++;
    });
    document.getElementById('empty').style.display = shown ? 'none' : 'block';
  </script>
@endpush
