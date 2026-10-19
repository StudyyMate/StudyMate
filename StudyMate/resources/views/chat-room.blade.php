@extends('layouts.app')

@section('title', 'Ruang Chat')
@section('page-class', 'room')
@section('main-class', 'room-main')

@section('content')
  <section class="conv-head">
    <a class="back" href="/chat" aria-label="Kembali" id="backBtn">
      <img src="{{ asset('image/e4c7b.svg') }}" width="18" height="18" alt="" />
    </a>
    <span class="ph">
      <span class="img" id="pPhoto">
        <img class="cover" src="{{ asset('image/935bb.png') }}" alt="" />
      </span>
      <span class="online" aria-label="Online"></span>
    </span>
    <div class="p-info">
      <h1 class="p-name pj-bold" id="pName">Utami Putri</h1>
      <p class="p-major pj-semi">Informatika</p>
      <p class="p-meta pj-med" id="pMeta">Surabaya &middot; Perempuan</p>
    </div>
  </section>

  <section class="conv pj-med" id="conv" aria-live="polite">
    <span class="date-chip pj-semi">Hari ini</span>
    <div class="msg">Aku agak bingung soal materi SQL<span class="meta">10.11</span></div>
    <div class="msg out">Oh aku sudah aku juga bingung materinya banyak<span class="meta">10.14<img src="{{ asset('image/2b924.svg') }}" width="12" height="12" alt="Terbaca" /></span></div>
    <div class="msg">Boleh belajar bareng nggak? biar lebih paham<span class="meta">10.16</span></div>
    <div class="msg out">Boleh! kita ketemuan lusa mau?<span class="meta">10.19<img src="{{ asset('image/2b924.svg') }}" width="12" height="12" alt="Terbaca" /></span></div>
    <div class="msg">Bisa aja, langsung buat jadwalnya<span class="meta">10.21</span></div>
    <div class="msg out">Oke, nanti aku bawa materi dari kampusku. Kamu kalau ada materi bawa aja<span class="meta">10.24<img src="{{ asset('image/2b924.svg') }}" width="12" height="12" alt="Terbaca" /></span></div>
    <div class="msg">Boleh, kita bahas besok ya!<span class="meta">10.24</span></div>
  </section>

  <form class="composer" id="composer">
    <div class="field">
      <input type="text" id="msgInput" placeholder="Ketik pesan..." autocomplete="off" aria-label="Ketik pesan" />
    </div>
    <button class="send" type="submit" aria-label="Kirim">
      <img src="{{ asset('image/343eb.svg') }}" width="19" height="19" alt="" />
    </button>
  </form>
@endsection

@push('scripts')
  <script>
    var people = {
      'Talitha Ameliya': { foto: '<img class="cover" src="{{ asset("image/ebb50.png") }}" alt="" />', meta: 'Surabaya  ·  Perempuan' },
      'Sugeng': { foto: '<img src="{{ asset("image/e93e1.png") }}" style="left:0.66%;top:-48.08%;width:100%;height:178.21%" alt="" />', meta: 'Lamongan  ·  Laki-laki' },
      'Anashtasya Aulia': { foto: '<img src="{{ asset("image/3c045.png") }}" style="left:0;top:-24.44%;width:100%;height:177.54%" alt="" />', meta: 'Yogyakarta  ·  Perempuan' },
      'Andin Nirwasita': { foto: '<img class="cover" src="{{ asset("image/0c0b6.png") }}" alt="" />', meta: 'Denpasar  ·  Perempuan' }
    };
    var conv = document.getElementById('conv');
    var nama = new URLSearchParams(location.search).get('nama');
    if (nama && people[nama]) {
      document.getElementById('pName').textContent = nama;
      document.getElementById('pMeta').textContent = people[nama].meta;
      document.getElementById('pPhoto').innerHTML = people[nama].foto;
      document.getElementById('backBtn').href = document.referrer.indexOf('/hasil') > -1 ? document.referrer : '/chat';
      conv.innerHTML = '<span class="date-chip pj-semi">Hari ini</span><p class="conv-empty">Mulai percakapan dengan ' + nama + ' untuk belajar bareng.</p>';
    }
    conv.scrollTop = conv.scrollHeight;

    function now() { var d = new Date(); return String(d.getHours()).padStart(2, '0') + '.' + String(d.getMinutes()).padStart(2, '0'); }
    function addOut(text) {
      var empty = conv.querySelector('.conv-empty'); if (empty) empty.remove();
      var m = document.createElement('div'); m.className = 'msg out';
      m.textContent = text;
      var meta = document.createElement('span'); meta.className = 'meta';
      meta.innerHTML = now() + '<img src="{{ asset("image/2b924.svg") }}" width="12" height="12" alt="Terkirim" />';
      m.appendChild(meta); conv.appendChild(m); conv.scrollTop = conv.scrollHeight;
    }
    document.getElementById('composer').addEventListener('submit', function (e) {
      e.preventDefault();
      var input = document.getElementById('msgInput'); var t = input.value.trim();
      if (!t) return; addOut(t); input.value = ''; input.focus();
    });
  </script>
@endpush
