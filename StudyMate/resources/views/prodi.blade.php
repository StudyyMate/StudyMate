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
  <p class="reg-lead" style="margin-bottom:16px">Membantu untuk menemukan teman yang relevan dengan program studi anda.</p>

  <form class="reg-form" action="{{ route('register.prodi.store') }}" method="POST" novalidate>
    @csrf

    @php
      $savedProdi = old('prodi', session('register.prodi', ''));
      $jurusans = [
        ['name' => 'Teknik Informatika', 'icon' => '5fc3f.svg', 'w' => '16.6667', 'h' => '10'],
        ['name' => 'Sistem Informasi', 'icon' => 'd15f7.svg', 'w' => '18.3333', 'h' => '14.1667'],
        ['name' => 'Ilmu Komputer', 'icon' => '7a522.svg', 'w' => '15', 'h' => '15'],
        ['name' => 'Teknik Elektro', 'icon' => '5fc3f.svg', 'w' => '16.6667', 'h' => '10'],
        ['name' => 'Teknik Industri', 'icon' => 'd15f7.svg', 'w' => '18.3333', 'h' => '14.1667'],
        ['name' => 'Manajemen', 'icon' => '8dc1e.svg', 'w' => '18.3333', 'h' => '13.3333'],
        ['name' => 'Akuntansi', 'icon' => '8dc1e.svg', 'w' => '18.3333', 'h' => '13.3333'],
        ['name' => 'Bisnis Digital', 'icon' => 'e84c3.svg', 'w' => '16.6667', 'h' => '13.3333'],
        ['name' => 'Desain Komunikasi Visual', 'icon' => '76251.svg', 'w' => '16.6667', 'h' => '16.6667'],
        ['name' => 'Ilmu Komunikasi', 'icon' => 'c05c6.svg', 'w' => '18.3333', 'h' => '16.25'],
        ['name' => 'Kedokteran', 'icon' => '731f3.svg', 'w' => '13.3333', 'h' => '16.6667'],
        ['name' => 'Farmasi', 'icon' => '731f3.svg', 'w' => '13.3333', 'h' => '16.6667'],
        ['name' => 'Psikologi', 'icon' => 'c05c6.svg', 'w' => '18.3333', 'h' => '16.25'],
        ['name' => 'Ilmu Hukum', 'icon' => '8dc1e.svg', 'w' => '18.3333', 'h' => '13.3333'],
      ];
      $jurusanNames = array_column($jurusans, 'name');
      $isCustom = $savedProdi && !in_array($savedProdi, $jurusanNames);
      $isOtherSelected = old('prodi') === 'Other' || $isCustom;
    @endphp

    <fieldset class="topics">
      <legend class="f-medium" style="position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0 0 0 0)">Program Studi</legend>

      @foreach ($jurusans as $j)
        @php $isChecked = ($savedProdi === $j['name'] && !$isOtherSelected); @endphp
        <label class="topic-item">
          <input type="radio" name="prodi" value="{{ $j['name'] }}" {{ $isChecked ? 'checked' : '' }} />
          <span class="topic-card f-medium">
            <span class="topic-main">
              <span class="topic-icon">
                <img src="{{ asset('image/' . $j['icon']) }}" width="{{ $j['w'] }}" height="{{ $j['h'] }}" alt="" />
              </span>
              {{ $j['name'] }}
            </span>
            <span class="topic-check">
              <img class="on" src="{{ asset('image/e0f80.svg') }}" width="12" height="9" alt="" />
              <img class="off" src="{{ asset('image/0bb8c.svg') }}" width="20" height="20" alt="" />
            </span>
          </span>
        </label>
      @endforeach

      {{-- Opsi Other --}}
      <div class="topic-other-wrap" style="display:flex;flex-direction:column;gap:8px">
        <label class="topic-item">
          <input type="radio" id="prodi_other_radio" name="prodi" value="Other" {{ $isOtherSelected ? 'checked' : '' }} />
          <span class="topic-card f-medium">
            <span class="topic-main">
              <span class="topic-icon">
                <img src="{{ asset('image/3161c.svg') }}" width="15" height="15" alt="" />
              </span>
              Other (Lainnya)
            </span>
            <span class="topic-check">
              <img class="on" src="{{ asset('image/e0f80.svg') }}" width="12" height="9" alt="" />
              <img class="off" src="{{ asset('image/0bb8c.svg') }}" width="20" height="20" alt="" />
            </span>
          </span>
        </label>
        <div id="other-input-container" style="{{ $isOtherSelected ? 'display:block;' : 'display:none;' }}padding:4px 0">
          <input class="input r12" id="prodi_other_input" name="prodi_other" type="text" placeholder="Tulis program studi Anda..." value="{{ old('prodi_other', $isCustom ? $savedProdi : '') }}" maxlength="100" style="background:#ffffff;border:1.5px solid #3525cd;font-size:14px;padding:12px 16px" />
        </div>
      </div>
    </fieldset>

    <span class="field-error-msg" id="prodi-error" style="display:{{ $errors->has('prodi') ? 'block' : 'none' }};margin-top:8px">
      {{ $errors->first('prodi') ?: 'Data tidak boleh kosong.' }}
    </span>

    <button class="cta r12" type="submit" style="letter-spacing:0.35px;margin-top:24px">
      Lanjut <img src="{{ asset('image/03d99.svg') }}" width="12" height="12" alt="" />
    </button>
  </form>

  <script>
    var radios = document.querySelectorAll('input[name="prodi"]');
    var otherRadio = document.getElementById('prodi_other_radio');
    var otherContainer = document.getElementById('other-input-container');
    var otherInput = document.getElementById('prodi_other_input');
    var prodiErr = document.getElementById('prodi-error');
    var form = document.querySelector('form.reg-form');

    function toggleOther() {
      if (otherRadio.checked) {
        otherContainer.style.display = 'block';
        otherInput.focus();
      } else {
        otherContainer.style.display = 'none';
        otherInput.classList.remove('is-invalid');
      }
    }

    radios.forEach(function(r) {
      r.addEventListener('click', function(e) {
        if (this.dataset.wasChecked === 'true') {
          this.checked = false;
          this.dataset.wasChecked = 'false';
          toggleOther();
        } else {
          radios.forEach(function(other) { other.dataset.wasChecked = 'false'; });
          this.dataset.wasChecked = 'true';
          prodiErr.style.display = 'none';
          toggleOther();
        }
      });
    });

    radios.forEach(function(r) {
      if (r.checked) {
        r.dataset.wasChecked = 'true';
      }
    });

    otherInput.addEventListener('input', function() {
      if (otherInput.value.trim()) {
        otherInput.classList.remove('is-invalid');
        prodiErr.style.display = 'none';
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
          prodiErr.textContent = 'Data tidak boleh kosong.';
          prodiErr.style.display = 'block';
          otherInput.focus();
          return;
        }
      }
    });
  </script>
@endsection
