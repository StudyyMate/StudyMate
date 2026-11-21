@extends('layouts.app')

@section('title', 'Cari Teman Belajar')
@section('main-class', 'cari-main')

@section('content')
  <div class="intro">
    <h1 class="page-title pj-xbold">Cari Teman Belajar</h1>
    <p class="page-lead pj-med">Temukan teman belajar yang sesuai dengan kriteriamu.</p>
  </div>

  <form class="filters" action="{{ route('hasil') }}" method="get">
    <div class="grid">
      <div class="field">
        <label class="field-label pj-bold" for="provinsi">Provinsi <span class="filter-optional">Opsional</span></label>
        <div class="select">
          <span class="lead"><img src="{{ asset('image/526d1.svg') }}" width="16" height="16" alt="" /></span>
          <select id="provinsi" name="provinsi">
            <option value="">Pilih provinsi...</option>
          </select>
          <img class="chev" src="{{ asset('image/9ef0f.svg') }}" width="16" height="16" alt="" />
        </div>
      </div>

      <div class="field">
        <label class="field-label pj-bold" for="kota">Lokasi (Kota) <span class="filter-optional">Opsional</span></label>
        <div class="select">
          <span class="lead"><img src="{{ asset('image/526d1.svg') }}" width="16" height="16" alt="" /></span>
          <select id="kota" name="kota" disabled>
            <option value="">Pilih provinsi terlebih dahulu</option>
          </select>
          <img class="chev" src="{{ asset('image/9ef0f.svg') }}" width="16" height="16" alt="" />
        </div>
      </div>

      <div class="field">
        <label class="field-label pj-bold" for="gender">Gender <span class="filter-optional">Opsional</span></label>
        <div class="select">
          <span class="lead"><img src="{{ asset('image/d7d7f.svg') }}" width="16" height="15" alt="" /></span>
          <select id="gender" name="gender">
            <option value="">Pilih Gender</option>
            <option value="Perempuan">Perempuan</option>
            <option value="Laki-laki">Laki-laki</option>
          </select>
          <img class="chev" src="{{ asset('image/9ef0f.svg') }}" width="16" height="16" alt="" />
        </div>
      </div>

      <div class="field">
        <label class="field-label pj-bold" for="prodi">Program Studi <span class="filter-optional">Opsional</span></label>
        <div class="select">
          <span class="lead"><img src="{{ asset('image/f48b8.svg') }}" width="17" height="17" alt="" /></span>
          <select id="prodi" name="prodi">
            <option value="">Pilih Program Studi</option>
            @foreach($filterOptions['prodis'] ?? [] as $prodiOption)
              <option value="{{ $prodiOption }}">{{ $prodiOption }}</option>
            @endforeach
          </select>
          <img class="chev" src="{{ asset('image/9ef0f.svg') }}" width="16" height="16" alt="" />
        </div>
      </div>

      <div class="field">
        <label class="field-label pj-bold" for="bidang">Bidang yang Diminati <span class="filter-optional">Opsional</span></label>
        <div class="select">
          <span class="lead"><img src="{{ asset('image/8b3b9.svg') }}" width="17" height="17" alt="" /></span>
          <select id="bidang" name="bidang">
            <option value="">Pilih bidang yang diminati</option>
            @foreach($filterOptions['interests'] ?? [] as $interestOption)
              <option value="{{ $interestOption }}">{{ $interestOption }}</option>
            @endforeach
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

  {{-- Section Rekomendasi Teman Belajar (Content-Based Filtering / FR-04 & Usecase 5) --}}
  <div class="intro tight" style="margin-top: 40px;">
    <h2 class="page-title pj-xbold" style="font-size: 20px;">Rekomendasi Teman Belajar</h2>
    <p class="page-lead pj-med">Disarankan khusus untukmu berdasarkan kesesuaian profil belajar.</p>
  </div>

  @if(isset($recommendations) && $recommendations->count() > 0)
    <ul class="results recommendation-results" id="results" style="margin-top: 16px;">
      @foreach($recommendations as $rec)
        @php
          $recLokasi = is_array($rec->lokasi) ? $rec->lokasi : json_decode($rec->lokasi ?? '[]', true);
          $recKota = $recLokasi['kota'] ?? ($recLokasi['provinsi'] ?? '-');
          $recMinat = $rec->minat_list;
          $fotoUrl = $rec->foto_profil ? asset('storage/' . $rec->foto_profil) : asset('image/avatar-default.svg');
        @endphp
        <li class="card recommendation-card" data-recommendation-index="{{ $loop->index }}">
          <div class="card-top">
            <span class="av-44">
              <img class="cover" style="border-radius: 50%;" src="{{ $fotoUrl }}" alt="{{ $rec->nama }}" onerror="this.onerror=null; this.removeAttribute('src');" />
            </span>
            <div class="card-info">
              <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px;">
                <p class="c-name pj-bold">{{ $rec->nama }}</p>
                {{-- <span class="pj-bold" style="font-size: 11px; background: #eef2ff; color: #3525cd; padding: 2px 8px; border-radius: 999px;">
                  {{ $rec->similarity_score }}% Cocok
                </span> --}}
              </div>
              <p class="c-major pj-med">{{ $rec->prodi ?? 'Belum memilih prodi' }}</p>
              <p class="c-meta pj-med">
                <span><img src="{{ asset('image/14c4a.svg') }}" width="11" height="11" alt="" />{{ $recKota }}</span>
                <span><img src="{{ asset('image/30868.svg') }}" width="11" height="11" alt="" />{{ $rec->gender ?? '-' }}</span>
              </p>
            </div>
          </div>
          <div class="card-foot">
            <div class="interests">
              @forelse(array_slice($recMinat, 0, 3) as $m)
                <span class="interest pj-bold">{{ $m }}</span>
              @empty
                <span class="interest pj-med" style="color: #888;">-</span>
              @endforelse
            </div>
            <a class="chat-btn pj-bold" href="{{ route('chat-room', ['partner' => $rec->id_user]) }}">
              <img src="{{ asset('image/de1a9.svg') }}" width="11" height="11" alt="" />Chat
            </a>
          </div>
        </li>
      @endforeach
    </ul>

    {{-- @if($recommendations->count() > 6)
      <div id="load-more-wrapper" style="display: flex; justify-content: center; margin-top: 24px;">
        <button id="load-more-recommendations" class="primary pj-bold" type="button">
          Muat Lebih Banyak
        </button>
      </div>
    @endif --}}
  @else
    <div style="text-align: center; padding: 32px 16px; background: #ffffff; border-radius: 12px; margin-top: 16px; border: 1px dashed #d1d5db;">
      <p class="pj-med" style="color: #6b7280; margin: 0;">Belum ada rekomendasi teman belajar yang sesuai</p>
    </div>
  @endif
@endsection

@push('scripts')
  <script>
    // Placeholder colour for unselected selects


    const provinceSelect = document.getElementById('provinsi');
    const citySelect = document.getElementById('kota');

    fetch('/api/wilayah/provinces')
      .then(function (r) { return r.json(); })
      .then(function (res) {
        if (!res || !res.data) return;
        res.data.sort(function (a, b) { return a.name.localeCompare(b.name); });
        res.data.forEach(function (p) {
          const opt = document.createElement('option');
          opt.value = p.name;
          opt.dataset.code = p.code;
          opt.textContent = p.name;
          provinceSelect.appendChild(opt);
        });
      })
      .catch(function (err) {
        console.error('Gagal mengambil data provinsi:', err);
      });

    if (provinceSelect && citySelect) {
      provinceSelect.addEventListener('change', function () {
        const selected = provinceSelect.options[provinceSelect.selectedIndex];
        const code = selected ? selected.dataset.code : null;

        if (!code) {
          citySelect.innerHTML = '<option value="">Pilih provinsi terlebih dahulu</option>';
          citySelect.disabled = true;
          return;
        }

        citySelect.innerHTML = '<option value="">Memuat kota / kabupaten...</option>';
        citySelect.disabled = true;

        fetch('/api/wilayah/regencies/' + code)
          .then(function (r) { return r.json(); })
          .then(function (res) {
            citySelect.innerHTML = '<option value="">Semua Kota / Kabupaten</option>';
            if (res && res.data) {
              res.data.sort(function (a, b) { return a.name.localeCompare(b.name); });
              res.data.forEach(function (k) {
                const opt = document.createElement('option');
                opt.value = k.name;
                opt.textContent = k.name;
                citySelect.appendChild(opt);
              });
            }
            citySelect.disabled = false;
          })
          .catch(function (err) {
            citySelect.innerHTML = '<option value="">Gagal memuat kota</option>';
            console.error('Gagal mengambil kota:', err);
          });
      });
    }
  </script>
@endpush
