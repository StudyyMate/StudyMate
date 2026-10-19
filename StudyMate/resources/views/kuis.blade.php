@extends('layouts.subpage')

@section('title', 'Kuis SQL & Database')
@section('page-title', 'Quiz Execution')
@section('back-url', '/materi')
@section('subpage-class', 'kz')
@section('subpage-attrs', 'id="kz"')
@section('subwrap-attrs', 'style="height:56px"')
@section('subtop-left-attrs', 'style="gap:4px"')
@section('subtitle-attrs', 'style="line-height:24px"')

@section('content')
  <div class="kz-top-bar">
    <div class="kz-top-left">
      <a class="kz-exit" href="/jadwal" aria-label="Keluar dari kuis">
        <img src="{{ asset('image/8625a.svg') }}" width="11.6667" height="11.6667" alt="" />
      </a>
      <div style="min-width:0">
        <p class="kz-kicker pj-bold">Quiz Session</p>
        <h2 class="kz-name pj-semi">Kuis SQL &amp; Database</h2>
      </div>
    </div>
    <span class="timer pj-bold" id="timer">
      <img src="{{ asset('image/bcf2b.svg') }}" width="12.6406" height="14.8667" alt="" />
      <span id="timeText">08:45</span>
    </span>
  </div>

  <div class="quiz-body">
    <div class="kz-progress">
      <div class="row-between">
        <p class="kz-count pj-semi">Soal <b id="qNum" style="font-weight:inherit">2</b> <span>dari 5</span></p>
        <span class="xp pj-bold">
          <img src="{{ asset('image/3f35a.svg') }}" width="9.33333" height="11.6667" alt="" />+20 XP Benar
        </span>
      </div>
      <div class="track"><span id="track" style="width:40%"></span></div>
    </div>

    <section class="q-card">
      <div class="row-between">
        <span class="topic pj-bold" id="qTopic">Query Relasional</span>
        <span class="weight pj-bold">
          <img src="{{ asset('image/f8fb8.svg') }}" width="13.3333" height="13.3333" alt="" />
          <span id="qWeight">Bobot: Sedang</span>
        </span>
      </div>
      <p class="q-text in-med" id="qText">Perintah SQL manakah yang paling tepat untuk menggabungkan dua tabel dan menampilkan semua data dari tabel kiri meskipun tidak ada kecocokan di tabel kanan?</p>
      <div class="code" id="qCode">
        <div class="row-between">
          <span class="code-file pj-semi"><img src="{{ asset('image/f408c.svg') }}" width="11.6667" height="9.33333" alt="" />schema_example.sql</span>
          <span class="code-lang pj-bold">SQL</span>
        </div>
        <pre class="mono" id="qCodeText">SELECT Mahasiswa.nama, Nilai.skor
FROM Mahasiswa
[ ___ ] Nilai ON Mahasiswa.id = Nilai.mhs_id;</pre>
      </div>
    </section>

    <ul class="options" id="options" role="radiogroup" aria-label="Pilihan jawaban"></ul>

    <div class="qnav" id="qnav" aria-label="Navigasi soal"></div>

    <div class="peer">
      <div class="l">
        <span class="ini pj-bold">UP</span>
        <p class="in-semi">Utami (Study Partner)<span class="in-reg"> juga sedang mengerjakan kuis ini.</span></p>
      </div>
      <span class="at pj-semi">Soal 3</span>
    </div>
  </div>

  <section class="result" aria-live="polite">
    <p class="kz-kicker pj-bold">Kuis Selesai</p>
    <p class="score pj-xbold" id="score">0/5</p>
    <p class="in-reg" id="xpText">Kamu mendapat 0 XP.</p>
    <a class="pj-bold" href="/jadwal">Kembali ke Jadwal</a>
  </section>

  <div class="kz-bottom">
    <div class="sub-wrap">
      <button type="button" class="kz-prev pj-bold" id="prevBtn">
        <img src="{{ asset('image/116ac.svg') }}" width="5.55" height="9" alt="" />Sebelumnya
      </button>
      <button type="button" class="kz-next pj-bold" id="nextBtn">
        <span id="nextLabel">Lanjut Soal</span>
        <img src="{{ asset('image/6fc5a.svg') }}" width="5.55" height="9" alt="" />
      </button>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    var Q = [
      { topic: 'Dasar Query', weight: 'Mudah', text: 'Perintah SQL apa yang digunakan untuk mengambil data dari sebuah tabel?', code: null, opts: ['SELECT', 'INSERT', 'UPDATE', 'DELETE'], ans: 0 },
      { topic: 'Query Relasional', weight: 'Sedang', text: 'Perintah SQL manakah yang paling tepat untuk menggabungkan dua tabel dan menampilkan semua data dari tabel kiri meskipun tidak ada kecocokan di tabel kanan?', code: 'SELECT Mahasiswa.nama, Nilai.skor\nFROM Mahasiswa\n[ ___ ] Nilai ON Mahasiswa.id = Nilai.mhs_id;', opts: ['INNER JOIN', 'LEFT JOIN', 'RIGHT JOIN', 'CROSS JOIN'], ans: 1 },
      { topic: 'Filter Data', weight: 'Sedang', text: 'Klausa apa yang dipakai untuk memfilter hasil setelah GROUP BY?', code: 'SELECT prodi, COUNT(*)\nFROM Mahasiswa\nGROUP BY prodi\n[ ___ ] COUNT(*) > 10;', opts: ['WHERE', 'HAVING', 'ORDER BY', 'LIMIT'], ans: 1 },
      { topic: 'Agregasi', weight: 'Mudah', text: 'Fungsi agregat apa yang menghitung rata-rata nilai sebuah kolom?', code: null, opts: ['SUM()', 'COUNT()', 'AVG()', 'MAX()'], ans: 2 },
      { topic: 'Desain Database', weight: 'Sulit', text: 'Constraint apa yang memastikan nilai pada kolom merujuk ke baris yang ada di tabel lain?', code: null, opts: ['PRIMARY KEY', 'UNIQUE', 'CHECK', 'FOREIGN KEY'], ans: 3 }
    ];
    var answers = [0, 1, null, null, null];
    var cur = 1;
    var keys = ['A', 'B', 'C', 'D'];
    var $ = function (id) { return document.getElementById(id); };

    function render() {
      var q = Q[cur];
      $('qNum').textContent = cur + 1;
      $('track').style.width = ((cur + 1) / Q.length * 100) + '%';
      $('qTopic').textContent = q.topic;
      $('qWeight').textContent = 'Bobot: ' + q.weight;
      $('qText').textContent = q.text;
      $('qCode').hidden = !q.code;
      if (q.code) $('qCodeText').textContent = q.code;
      $('options').innerHTML = q.opts.map(function (o, i) {
        return '<li><button type="button" class="opt" role="radio" data-i="' + i + '" aria-checked="' + (answers[cur] === i) + '">' +
          '<span class="l"><span class="key pj-bold">' + keys[i] + '</span><span class="label">' + o + '</span></span>' +
          '<span class="radio"><img src="{{ asset("image/09465.svg") }}" width="10.8667" height="8.01667" alt="" /></span></button></li>';
      }).join('');
      $('qnav').innerHTML = Q.map(function (_, i) {
        var cls = (answers[i] !== null ? 'done ' : '') + (i === cur ? 'active' : '');
        return '<button type="button" class="' + cls + '" data-q="' + i + '" aria-label="Soal ' + (i + 1) + '">' + (i + 1) +
          '<img class="ok" src="{{ asset("image/4f187.svg") }}" width="10.8333" height="10.8333" alt="" /><span class="cur"></span></button>';
      }).join('');
      $('prevBtn').disabled = cur === 0;
      $('nextLabel').textContent = cur === Q.length - 1 ? 'Selesai' : 'Lanjut Soal';
    }

    $('options').addEventListener('click', function (e) {
      var b = e.target.closest('.opt'); if (!b) return;
      answers[cur] = Number(b.dataset.i); render();
    });
    $('qnav').addEventListener('click', function (e) {
      var b = e.target.closest('button'); if (!b) return;
      cur = Number(b.dataset.q); render();
    });
    $('prevBtn').addEventListener('click', function () { if (cur > 0) { cur--; render(); } });
    $('nextBtn').addEventListener('click', function () {
      if (cur < Q.length - 1) { cur++; render(); window.scrollTo({ top: 0, behavior: 'smooth' }); return; }
      var empty = answers.indexOf(null);
      if (empty > -1 && !confirm('Masih ada soal yang belum dijawab. Selesaikan kuis sekarang?')) { cur = empty; render(); return; }
      finish();
    });

    function finish() {
      clearInterval(tick);
      var right = answers.filter(function (a, i) { return a === Q[i].ans; }).length;
      $('score').textContent = right + '/' + Q.length;
      $('xpText').textContent = 'Kamu mendapat ' + (right * 20) + ' XP dari kuis ini.';
      $('kz').classList.add('finished');
      window.scrollTo({ top: 0 });
    }

    var left = 8 * 60 + 45;
    var tick = setInterval(function () {
      left--;
      $('timeText').textContent = String(Math.floor(left / 60)).padStart(2, '0') + ':' + String(left % 60).padStart(2, '0');
      if (left <= 60) $('timer').classList.add('low');
      if (left <= 0) finish();
    }, 1000);

    render();
  </script>
@endpush
