@extends('layouts.app')

@section('title', 'Cari Teman Belajar')
@section('main-class', 'cari-main')

@section('content')
  <div class="intro">
    <h1 class="page-title pj-xbold">Cari Teman Belajar</h1>
    <p class="page-lead pj-med">Temukan teman belajar yang sesuai dengan kriteriamu.</p>
  </div>

  <form class="filters" action="/hasil" method="get">
    <div class="grid">
      <div class="field">
        <label class="field-label pj-bold" for="kota">Lokasi (Kota)</label>
        <div class="select">
          <span class="lead"><img src="{{ asset('image/526d1.svg') }}" width="16" height="16" alt="" /></span>
          <select id="kota" name="kota">
            <option value="">Pilih Kota</option>
            <option>Surabaya</option>
            <option>Lamongan</option>
            <option>Yogyakarta</option>
            <option>Denpasar</option>
            <option>Malang</option>
            <option>Jakarta</option>
          </select>
          <img class="chev" src="{{ asset('image/9ef0f.svg') }}" width="16" height="16" alt="" />
        </div>
      </div>

      <div class="field">
        <label class="field-label pj-bold" for="gender">Gender</label>
        <div class="select">
          <span class="lead"><img src="{{ asset('image/d7d7f.svg') }}" width="16" height="15" alt="" /></span>
          <select id="gender" name="gender">
            <option value="">Pilih Gender</option>
            <option>Perempuan</option>
            <option>Laki-laki</option>
          </select>
          <img class="chev" src="{{ asset('image/9ef0f.svg') }}" width="16" height="16" alt="" />
        </div>
      </div>

      <div class="field">
        <label class="field-label pj-bold" for="prodi">Program Studi</label>
        <div class="select">
          <span class="lead"><img src="{{ asset('image/f48b8.svg') }}" width="17" height="17" alt="" /></span>
          <select id="prodi" name="prodi">
            <option value="">Pilih Program Studi</option>
            <option selected>Informatika</option>
            <option>Sistem Informasi</option>
            <option>Teknik Komputer</option>
            <option>Data Science</option>
          </select>
          <img class="chev" src="{{ asset('image/9ef0f.svg') }}" width="16" height="16" alt="" />
        </div>
      </div>

      <div class="field">
        <label class="field-label pj-bold" for="bidang">Bidang yang Diminati</label>
        <div class="select">
          <span class="lead"><img src="{{ asset('image/8b3b9.svg') }}" width="17" height="17" alt="" /></span>
          <select id="bidang" name="bidang">
            <option value="">Pilih bidang yang diminati</option>
            <option>Database</option>
            <option>SQL</option>
            <option>Python Algorithm</option>
            <option>Computer Network</option>
            <option>Web Dev</option>
            <option>AI</option>
            <option>Cyber Security</option>
            <option>UI/UX</option>
          </select>
          <img class="chev" src="{{ asset('image/9ef0f.svg') }}" width="16" height="16" alt="" />
        </div>
      </div>
    </div>

    <div class="search-action">
      <button class="primary pj-bold" type="submit">
        Cari Teman
        <img src="{{ asset('image/66839.svg') }}" width="17" height="17" alt="" />
      </button>
      <p class="hint pj-med">Lihat teman belajar yang paling cocok untukmu</p>
    </div>
  </form>
@endsection

@push('scripts')
  <script>
    // Placeholder colour for unselected selects
    document.querySelectorAll('.filters select').forEach(function (s) {
      var sync = function () { s.style.color = s.value ? '#131b2e' : '#7a818a'; };
      s.addEventListener('change', sync); sync();
    });
  </script>
@endpush
