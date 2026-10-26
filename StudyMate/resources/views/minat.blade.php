@extends('layouts.register')

@section('title', 'Daftar - Fokus Minat')
@section('progress', '60%')
@section('back-url', '/prodi')
@section('page-style', '--grad-top: #cde6ff; --grad-bottom: #ffffff')
@section('track-style', '--track: #e2e7ff')
@section('main-attrs', 'style="padding-top:24px"')

@section('content')
  @php
    $saved = session('register.bidang_diminati');
    if (is_array($saved)) {
        $defaultSelected = $saved['predefined'] ?? [];
        if (!empty($saved['custom'])) {
            $defaultSelected[] = 'Other';
        }
    } elseif (is_string($saved) && $saved !== '') {
        $defaultSelected = explode(', ', $saved);
    } else {
        $defaultSelected = ['Software Engineering', 'Artificial Intelligence'];
    }
    $selected = old('minat', $defaultSelected);
  @endphp

  <div class="reg-step is-split" style="padding-bottom:16px">
    <span class="f-semibold" style="color:#464555;font-size:12px;line-height:16px;letter-spacing:0.6px">LANGKAH 03 / 05</span>
    <span class="pill f-medium" style="font-size:12px;line-height:16px;letter-spacing:0.48px"><span class="dot" style="width:6px;height:6px;background:#3525cd"></span><span id="minat-count-text">{{ count($selected) }} dipilih (Maks. 3)</span></span>
  </div>
  <h1 class="reg-title">Apa fokus minat Anda?</h1>
  <p class="reg-lead" style="margin-bottom:16px">Pilih 1–3 bidang yang relevan dengan jalur karier atau skripsi Anda.</p>

  @if ($errors->any())
    <div style="background:#ffdad8;color:#ad2f34;padding:10px 14px;border-radius:8px;font-size:13px;margin-bottom:12px">
      <ul style="margin:0;padding:0 0 0 16px">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('register.minat.store') }}" method="POST" novalidate>
    @csrf
    <fieldset class="topics">
      <legend class="f-medium" style="position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0 0 0 0)">Fokus minat</legend>

      @php
        $topics = [
          ['name' => 'Software Engineering', 'icon' => '5fc3f.svg', 'w' => '16.6667', 'h' => '10'],
          ['name' => 'Artificial Intelligence & ML', 'icon' => '7a522.svg', 'w' => '15', 'h' => '15'],
          ['name' => 'UI/UX & Product Design', 'icon' => '76251.svg', 'w' => '16.6667', 'h' => '16.6667'],
          ['name' => 'Data Science & Analytics', 'icon' => 'c05c6.svg', 'w' => '18.3333', 'h' => '16.25'],
          ['name' => 'Cloud Computing & DevOps', 'icon' => '5fc3f.svg', 'w' => '16.6667', 'h' => '10'],
          ['name' => 'Cyber Security', 'icon' => '731f3.svg', 'w' => '13.3333', 'h' => '16.6667'],
          ['name' => 'Mobile App Development', 'icon' => '76251.svg', 'w' => '16.6667', 'h' => '16.6667'],
          ['name' => 'Database & Big Data', 'icon' => 'd15f7.svg', 'w' => '18.3333', 'h' => '14.1667'],
          ['name' => 'Game Development', 'icon' => '7a522.svg', 'w' => '15', 'h' => '15'],
          ['name' => 'Finance & Investment', 'icon' => '8dc1e.svg', 'w' => '18.3333', 'h' => '13.3333'],
          ['name' => 'Digital Marketing', 'icon' => 'e84c3.svg', 'w' => '16.6667', 'h' => '13.3333'],
          ['name' => 'IoT & Embedded Systems', 'icon' => 'd15f7.svg', 'w' => '18.3333', 'h' => '14.1667'],
          ['name' => 'Blockchain & Web3', 'icon' => '8dc1e.svg', 'w' => '18.3333', 'h' => '13.3333'],
          ['name' => 'Research & Academics', 'icon' => 'c05c6.svg', 'w' => '18.3333', 'h' => '16.25'],
        ];

        $isOtherChecked = in_array('Other', $selected) || session('register.minat_other') || old('minat_other');
      @endphp

      @foreach ($topics as $t)
        @php $isChecked = in_array($t['name'], $selected); @endphp
        <label class="topic-item">
          <input type="checkbox" name="minat[]" value="{{ $t['name'] }}" {{ $isChecked ? 'checked' : '' }} />
          <span class="topic-card f-medium">
            <span class="topic-main">
              <span class="topic-icon">
                <img src="{{ asset('image/' . $t['icon']) }}" width="{{ $t['w'] }}" height="{{ $t['h'] }}" alt="" />
              </span>
              {{ $t['name'] }}
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
          <input type="checkbox" id="minat_other_checkbox" name="minat[]" value="Other" {{ $isOtherChecked ? 'checked' : '' }} />
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
        <div id="other-input-container" style="{{ $isOtherChecked ? 'display:block;' : 'display:none;' }}padding:4px 0">
          <input class="input r12" id="minat_other_input" name="minat_other" type="text" placeholder="Tulis bidang minat Anda (Wajib diisi)..." value="{{ old('minat_other', session('register.minat_other', '')) }}" maxlength="50" style="background:#ffffff;border:1.5px solid #3525cd;font-size:14px;padding:12px 16px" {{ $isOtherChecked ? 'required' : '' }} />
        </div>
      </div>
    </fieldset>

    <button class="cta r12" type="submit" style="letter-spacing:0.35px">
      Lanjut <img src="{{ asset('image/03d99.svg') }}" width="12" height="12" alt="" />
    </button>
    <p class="footnote f-medium" style="padding-top:20px">
      <img src="{{ asset('image/3161c.svg') }}" width="9.33333" height="12.25" alt="" />
      Dapat diubah kembali melalui pengaturan profil
    </p>
  </form>

  <script>
    var checkboxes = document.querySelectorAll('.topic-item input[type="checkbox"]');
    var countText = document.getElementById('minat-count-text');
    var otherCheckbox = document.getElementById('minat_other_checkbox');
    var otherContainer = document.getElementById('other-input-container');
    var otherInput = document.getElementById('minat_other_input');

    function toggleOtherInput() {
      if (otherCheckbox.checked) {
        otherContainer.style.display = 'block';
        otherInput.required = true;
        otherInput.focus();
      } else {
        otherContainer.style.display = 'none';
        otherInput.required = false;
        otherInput.value = '';
      }
    }

    function updateCount() {
      var checked = document.querySelectorAll('.topic-item input[type="checkbox"]:checked');
      countText.textContent = checked.length + ' dipilih (Maks. 3)';
    }

    otherCheckbox.addEventListener('change', function() {
      toggleOtherInput();
    });

    checkboxes.forEach(function(cb) {
      cb.addEventListener('change', function() {
        var checked = document.querySelectorAll('.topic-item input[type="checkbox"]:checked');
        if (checked.length > 3) {
          this.checked = false;
          if (this === otherCheckbox) {
            toggleOtherInput();
          }
          alert('Maksimal memilih 3 bidang minat!');
          return;
        }
        updateCount();
      });
    });

    // Initial check on load
    updateCount();
  </script>
@endsection
