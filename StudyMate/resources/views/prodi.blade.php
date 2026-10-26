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
  </div>
  <h1 class="reg-title">Pilih program studi Anda</h1>
  <p class="reg-lead">Membantu untuk menemukan teman yang relevan dengan program studi anda.</p>

  <form class="reg-form" action="{{ route('register.prodi.store') }}" method="POST" novalidate>
    @csrf

    @php
      $savedProdi = old('prodi', session('register.prodi', ''));
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
      $isCustom = $savedProdi && !in_array($savedProdi, $jurusans);
      $isOtherSelected = old('prodi') === 'Other' || $isCustom;
    @endphp

    <fieldset class="chip-group" style="margin-top:8px">
      <legend class="f-semibold" style="margin-bottom:12px">Pilihan Program Studi Populer</legend>
      <div class="chips f-medium" id="prodi-chips">
        @foreach ($jurusans as $j)
          <label class="chip">
            <input type="radio" name="prodi" value="{{ $j }}" {{ ($savedProdi === $j && !$isOtherSelected) ? 'checked' : '' }} />
            <span>{{ $j }}</span>
          </label>
        @endforeach
        <label class="chip">
          <input type="radio" id="prodi_other_radio" name="prodi" value="Other" {{ $isOtherSelected ? 'checked' : '' }} />
          <span>Other</span>
        </label>
      </div>
      <span class="field-error-msg" id="prodi-error" style="display:{{ $errors->has('prodi') && !$isOtherSelected ? 'block' : 'none' }};margin-top:8px">
        {{ $errors->first('prodi') ?: 'Data tidak boleh kosong.' }}
      </span>
    </fieldset>

    {{-- Input teks jika Other dipilih --}}
    <div id="other-input-container" style="{{ $isOtherSelected ? 'display:block;' : 'display:none;' }}margin-top:16px;">
      <label class="label f-medium" for="prodi_other" style="display:block;margin-bottom:6px">Tulis Program Studi Anda</label>
      <div class="input-wrap">
        <input class="input @error('prodi') is-invalid @enderror" id="prodi_other" name="prodi_other" type="text" placeholder="Tuliskan nama program studi..." value="{{ old('prodi_other', $isCustom ? $savedProdi : '') }}" maxlength="100" />
      </div>
      <span class="field-error-msg" id="prodi-other-error" style="display:{{ $errors->has('prodi') && $isOtherSelected ? 'block' : 'none' }}">
        {{ $errors->first('prodi') ?: 'Data tidak boleh kosong.' }}
      </span>
    </div>

    <button class="cta" type="submit" style="margin-top:40px">
      Lanjut <img src="{{ asset('image/03d99.svg') }}" width="12" height="12" alt="" />
    </button>
  </form>

  <script>
    var radios = document.querySelectorAll('input[name="prodi"]');
    var otherRadio = document.getElementById('prodi_other_radio');
    var otherContainer = document.getElementById('other-input-container');
    var otherInput = document.getElementById('prodi_other');
    var prodiErr = document.getElementById('prodi-error');
    var otherErr = document.getElementById('prodi-other-error');
    var form = document.querySelector('form.reg-form');

    function toggleOther() {
      if (otherRadio.checked) {
        otherContainer.style.display = 'block';
        otherInput.focus();
      } else {
        otherContainer.style.display = 'none';
        otherInput.classList.remove('is-invalid');
        otherErr.style.display = 'none';
      }
    }

    radios.forEach(function(r) {
      r.addEventListener('change', function() {
        prodiErr.style.display = 'none';
        toggleOther();
      });
    });

    otherInput.addEventListener('input', function() {
      if (otherInput.value.trim()) {
        otherInput.classList.remove('is-invalid');
        otherErr.style.display = 'none';
      }
    });

    otherInput.addEventListener('blur', function() {
      if (otherRadio.checked && !otherInput.value.trim()) {
        otherInput.classList.add('is-invalid');
        otherErr.textContent = 'Data tidak boleh kosong.';
        otherErr.style.display = 'block';
      }
    });

    form.addEventListener('submit', function(e) {
      var selectedRadio = document.querySelector('input[name="prodi"]:checked');

      if (!selectedRadio) {
        e.preventDefault();
        prodiErr.textContent = 'Data tidak boleh kosong.';
        prodiErr.style.display = 'block';
        return;
      }

      if (selectedRadio.value === 'Other') {
        if (!otherInput.value.trim()) {
          e.preventDefault();
          otherInput.classList.add('is-invalid');
          otherErr.textContent = 'Data tidak boleh kosong.';
          otherErr.style.display = 'block';
          otherInput.focus();
          return;
        }
      }
    });
  </script>
@endsection
