@extends('layouts.register')

@section('title', 'Daftar - Wilayah & Domisili')
@section('progress', '80%')
@section('back-url', '/minat')
@section('page-style', '--grad-top: #cce4fd')
@section('track-style', '--track: #e2e7ff')

@section('content')
  <div class="reg-step" style="padding-bottom:12px">
    <span class="f-semibold" style="color:#408bc9;letter-spacing:1.1px">LANGKAH 04 / 05</span>
    <span class="dot" style="width:6px;height:6px;background:#c3c0ff"></span>
    <span class="f-medium" style="color:#464555;letter-spacing:0.66px">Wilayah &amp; Zona Waktu</span>
  </div>
  <h1 class="reg-title">Di mana lokasi domisili Anda?</h1>
  <p class="reg-lead" style="margin-bottom:32px">Untuk menghubungkan Anda dengan study group terdekat dan penyesuaian zona waktu.</p>

  @if ($errors->any())
    <div style="background:#ffdad8;color:#ad2f34;padding:10px 14px;border-radius:8px;font-size:13px;margin-bottom:12px">
      <ul style="margin:0;padding:0 0 0 16px">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form class="reg-form" style="gap:20px" action="{{ route('register.domisili.store') }}" method="POST">
    @csrf
    <div class="field" style="gap:6px">
      <div class="field-label">
        <label class="label f-medium" for="provinsi">Provinsi</label>
        <span class="hint">Wajib diisi</span>
      </div>
      <div class="select-wrap">
        <select class="select" id="provinsi" name="provinsi" required>
          <option value="" disabled selected>Pilih provinsi...</option>
        </select>
        <img src="{{ asset('image/ab41e.svg') }}" width="10" height="6.16667" alt="" />
      </div>
    </div>

    <div class="field" style="gap:6px">
      <div class="field-label">
        <label class="label f-medium" for="kota">Kota / Kabupaten</label>
        <span class="hint f-medium">Wajib diisi</span>
      </div>
      <div class="select-wrap">
        <select class="select" id="kota" name="kota" required disabled>
          <option value="" disabled selected>Pilih provinsi dulu...</option>
        </select>
        <img src="{{ asset('image/ab41e.svg') }}" width="10" height="6.16667" alt="" />
      </div>
    </div>

    <button class="cta r12" type="submit" style="gap:6px;margin-top:149px">
      Lanjut <img src="{{ asset('image/03d99.svg') }}" width="12" height="12" alt="" />
    </button>
  </form>

  <script>
    var provSelect = document.getElementById('provinsi');
    var kotaSelect = document.getElementById('kota');

    fetch('/api/wilayah/provinces')
      .then(function(r) { return r.json(); })
      .then(function(res) {
        if (!res || !res.data) return;
        res.data.sort(function(a, b) { return a.name.localeCompare(b.name); });
        res.data.forEach(function(p) {
          var opt = document.createElement('option');
          opt.value = p.name;
          opt.dataset.code = p.code;
          opt.textContent = p.name;
          provSelect.appendChild(opt);
        });

        var oldProv = @json(old('provinsi', session('register.provinsi', '')));
        if (oldProv) {
          for (var i = 0; i < provSelect.options.length; i++) {
            if (provSelect.options[i].value === oldProv) {
              provSelect.selectedIndex = i;
              provSelect.dispatchEvent(new Event('change'));
              break;
            }
          }
        }
      })
      .catch(function(err) {
        console.error('Gagal mengambil data provinsi:', err);
      });

    provSelect.addEventListener('change', function() {
      var sel = provSelect.options[provSelect.selectedIndex];
      var code = sel ? sel.dataset.code : null;
      if (!code) return;

      kotaSelect.innerHTML = '<option value="" disabled selected>Memuat kota / kabupaten...</option>';
      kotaSelect.disabled = true;

      fetch('/api/wilayah/regencies/' + code)
        .then(function(r) { return r.json(); })
        .then(function(res) {
          kotaSelect.innerHTML = '<option value="" disabled selected>Pilih kota / kabupaten...</option>';
          if (res && res.data) {
            res.data.sort(function(a, b) { return a.name.localeCompare(b.name); });
            res.data.forEach(function(k) {
              var opt = document.createElement('option');
              opt.value = k.name;
              opt.textContent = k.name;
              kotaSelect.appendChild(opt);
            });
          }
          kotaSelect.disabled = false;

          var oldKota = @json(old('kota', session('register.kota', '')));
          if (oldKota) {
            for (var i = 0; i < kotaSelect.options.length; i++) {
              if (kotaSelect.options[i].value === oldKota) {
                kotaSelect.selectedIndex = i;
                break;
              }
            }
          }
        })
        .catch(function(err) {
          kotaSelect.innerHTML = '<option value="" disabled selected>Gagal memuat kota</option>';
          console.error('Gagal mengambil kota:', err);
        });
    });
  </script>
@endsection
