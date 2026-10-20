@extends('layouts.register')

@section('title', 'Daftar - Program Studi')
@section('progress', '40%')
@section('back-url', '/register')
@section('page-style', '--grad-top: #cde6ff')
@section('track-style', '--track: #ffffff')

@section('content')
  <div class="reg-step is-split">
    <div class="reg-step-group">
      <span class="f-semibold" style="color:#3525cd;letter-spacing:1.1px">LANGKAH 02</span>
      <span class="f-medium" style="color:#c7c4d8;letter-spacing:0.66px">/</span>
      <span class="f-medium" style="color:#464555;letter-spacing:0.55px">05 AKADEMIK</span>
    </div>
    <span class="f-medium" style="color:rgba(70,69,85,0.8);letter-spacing:0.66px">Estimasi 1 mnt</span>
  </div>
  <h1 class="reg-title">Pilih program studi Anda</h1>
  <p class="reg-lead">Membantu untuk menemukan teman yang relevan dengan program studi anda.</p>

  @if ($errors->any())
    <div style="background:#ffdad8;color:#ad2f34;padding:10px 14px;border-radius:8px;font-size:13px;margin-bottom:12px">
      <ul style="margin:0;padding:0 0 0 16px">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form class="reg-form" action="{{ route('register.prodi.store') }}" method="POST">
    @csrf
    <div class="field" style="gap:4px">
      <label class="label f-medium" for="prodi">Program Studi</label>
      <div class="input-wrap">
        <span class="input-icon"><img src="{{ asset('image/94b7e.svg') }}" width="15" height="15" alt="" /></span>
        <input class="input has-icon is-search" id="prodi" name="prodi" type="search" placeholder="Cari atau ketik program studi" value="{{ old('prodi', session('register.prodi')) }}" required autocomplete="off" />
      </div>
    </div>

    @php
      $currentProdi = old('prodi', session('register.prodi'));
      $jurusans = [
        'Teknik Informatika',
        'Sistem Informasi',
        'Ilmu Komputer',
        'Teknik Elektro',
        'Teknik Industri',
        'Manajemen',
        'Akuntansi',
        'Bisnis Digital',
        'Desain Komunikasi Visual',
        'Ilmu Komunikasi',
        'Kedokteran',
        'Farmasi',
        'Psikologi',
        'Ilmu Hukum',
      ];
    @endphp

    <fieldset class="chip-group" style="margin-top:16px">
      <legend class="f-semibold" style="margin-bottom:8px">Pilihan Jurusan Populer</legend>
      <div class="chips f-medium" id="jurusan-chips">
        @foreach ($jurusans as $j)
          <label class="chip">
            <input type="radio" name="jurusan_chip" value="{{ $j }}" {{ $currentProdi === $j ? 'checked' : '' }} />
            <span>{{ $j }}</span>
          </label>
        @endforeach
      </div>
    </fieldset>

    <button class="cta" type="submit" style="margin-top:40px">
      Lanjut <img src="{{ asset('image/03d99.svg') }}" width="12" height="12" alt="" />
    </button>
  </form>

  <script>
    var prodiInput = document.getElementById('prodi');
    var chips = document.querySelectorAll('input[name="jurusan_chip"]');

    chips.forEach(function(radio) {
      radio.addEventListener('change', function() {
        if (this.checked) {
          prodiInput.value = this.value;
          prodiInput.focus();
        }
      });
    });

    prodiInput.addEventListener('input', function() {
      var val = this.value.trim().toLowerCase();
      chips.forEach(function(radio) {
        if (radio.value.toLowerCase() === val) {
          radio.checked = true;
        } else {
          radio.checked = false;
        }
      });
    });
  </script>
@endsection
