@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" />
<style>
  .modal-crop-backdrop {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(15, 23, 42, 0.75);
    backdrop-filter: blur(4px);
    z-index: 99999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 16px;
  }
  .modal-crop-box {
    background: #ffffff;
    border-radius: 16px;
    max-width: 540px;
    width: 100%;
    overflow: hidden;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    display: flex;
    flex-direction: column;
    animation: modalPop 0.2s ease-out;
  }
  @keyframes modalPop {
    from { transform: scale(0.95); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
  }
  .modal-crop-head {
    padding: 16px 20px;
    border-bottom: 1px solid #eef2f6;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  .modal-crop-title {
    font-size: 16px;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
  }
  .modal-crop-body {
    padding: 16px 20px;
    background: #0f172a;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 320px;
    max-height: 60vh;
  }
  .modal-crop-body img {
    max-width: 100%;
    max-height: 55vh;
    display: block;
  }
  .modal-crop-foot {
    padding: 14px 20px;
    border-top: 1px solid #eef2f6;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    background: #ffffff;
  }
  .btn-crop-cancel {
    padding: 8px 16px;
    border-radius: 8px;
    border: 1px solid #c7c4d8;
    background: #ffffff;
    color: #475569;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
  }
  .btn-crop-save {
    padding: 8px 18px;
    border-radius: 8px;
    border: none;
    background: #084d79;
    color: #ffffff;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    box-shadow: 0 2px 6px rgba(53, 37, 205, 0.3);
  }
  .cropper-view-box,
  .cropper-face {
    border-radius: 50%;
  }
</style>
@endpush

@section('title', 'Profil Belajar')
@section('page-class', 'profil-page')
@section('main-class', 'pf-main')

@section('content')
  @php
    $u = Auth::user();
    $userName   = $u->nama ?? '-';
    $userEmail  = $u->email ?? '-';
    $userProdi  = $u->prodi ?? '-';
    $userStreak = $u->streak ?? 0;
    $userGender = $u->gender ?? '-';

    $minatRaw = $u->bidang_diminati;
    $savedMinatPredefined = [];
    $savedMinatCustom = '';
    if (is_array($minatRaw)) {
        $savedMinatPredefined = $minatRaw['predefined'] ?? [];
        $savedMinatCustom     = $minatRaw['custom'] ?? '';
        $allMinat             = array_filter(array_merge($savedMinatPredefined, $savedMinatCustom ? [$savedMinatCustom] : []));
        $userMinatText        = implode(', ', $allMinat);
    } elseif (is_string($minatRaw) && $minatRaw !== '') {
        $savedMinatPredefined = array_map('trim', explode(',', $minatRaw));
        $userMinatText        = $minatRaw;
    } else {
        $userMinatText = '-';
    }

    if (is_array($u?->lokasi)) {
      $currentKota = $u->lokasi['kota'] ?? '';
      $currentProv = $u->lokasi['provinsi'] ?? '';
    } else {
      $currentKota = $u?->lokasi ?? '';
      $currentProv = '';
    }
    $userKota = $currentKota ?: '-';
    $userProv = $currentProv;

    $avatarUrl = ($u && $u->foto_profil)
      ? asset('storage/' . $u->foto_profil)
      : asset('image/fc5ce.png');

    // Nilai form edit (mengutamakan old() jika ada)
    $editNama   = old('nama', $u->nama ?? '');
    $editGender = old('gender', $u->gender ?? '');
    $editProdi  = old('prodi', $u->prodi ?? '');
    $editProv   = old('provinsi', $currentProv);
    $editKota   = old('kota', $currentKota);

    $selectedMinat = old('minat', $savedMinatPredefined);
    $selectedMinatOther = old('minat_other', $savedMinatCustom);
    if ($selectedMinatOther && !in_array('Other', $selectedMinat)) {
        $selectedMinat[] = 'Other';
    }

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
    $isCustomProdi = $editProdi && !in_array($editProdi, $jurusans);
    $isOtherProdiSelected = old('prodi') === 'Other' || $isCustomProdi;
    $prodiOtherValue = old('prodi_other', $isCustomProdi ? $editProdi : '');

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

    $hasErrors = isset($errors) && $errors->any();
  @endphp

  @if (session('success'))
    <div style="background:#d4edda;color:#155724;padding:12px 16px;border-radius:10px;font-size:14px;margin-bottom:16px;display:flex;align-items:center;gap:8px">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  <div class="pf-head">
    <div>
      <h1 class="pf-title pj-xbold" id="page-main-heading">{{ $hasErrors ? 'Edit Profil Belajar' : 'Profil Belajar' }}</h1>
      <p class="jd-sub in-reg" id="page-sub-heading">{{ $hasErrors ? 'Perbarui identitas dan preferensi belajarmu' : 'Kelola profil dan preferensi akunmu' }}</p>
    </div>
    <button class="pf-edit pj-semi" id="btn-toggle-edit" type="button" style="cursor:pointer;border:none">
      <img src="{{ asset('image/49219.svg') }}" width="13.5" height="13.5" alt="" />
      <span id="btn-toggle-text">{{ $hasErrors ? 'Batal Edit' : 'Edit Profil' }}</span>
    </button>
  </div>

  <div class="pf-grid">
    {{-- Ringkasan kiri --}}
    <section class="pf-card pf-summary" aria-label="Ringkasan profil">
      <div class="pf-avatar" id="avatar-container">
        <img id="profile-avatar-img" src="{{ $avatarUrl }}" alt="Foto {{ $userName }}" style="object-fit:cover;width:100%;height:100%" />
        <span class="pf-online" aria-label="Online"></span>
      </div>

      <div id="avatar-btn-wrap" style="display:{{ $hasErrors ? 'block' : 'none' }};margin-top:10px;text-align:center">
        <button type="button" class="pj-semi" onclick="document.getElementById('foto_profil').click()" style="background:#f0f4ff;color:#3525cd;border:1px solid #c7c4d8;border-radius:8px;padding:6px 14px;font-size:12px;cursor:pointer">
          Pilih Foto Baru
        </button>
        <p style="font-size:11px;color:#888;margin-top:4px">JPG, PNG, atau WEBP. Maks 2MB.</p>
        <span class="field-error-msg" id="avatar-error" style="display:{{ $errors->has('foto_profil') ? 'block' : 'none' }};margin-top:6px;text-align:center">
          {{ $errors->first('foto_profil') }}
        </span>
      </div>

      <h2 class="pf-name pj-bold" id="sidebar-name">{{ $userName }}</h2>
      <p class="pf-sub pj-semi" id="sidebar-sub">{{ $userProdi }} &bull; {{ $userKota }}</p>

      <div class="pf-badges pj-semi">
        <span class="pf-badge streak" style="display:inline-flex;flex-direction:row;align-items:center;gap:6px;padding:4px 12px">
          <img src="{{ asset('image/65d39.svg') }}" width="11" height="13" alt="" style="display:inline-block;flex-shrink:0" />
          <span>{{ $userStreak }} Hari Streak</span>
        </span>
      </div>

      <dl class="pf-facts">
        <div class="pf-fact">
          <span class="pf-fact-ico"><img src="{{ asset('image/b4263.svg') }}" width="15" height="12" alt="" /></span>
          <div><dt class="pj-bold">Email</dt><dd class="in-med">{{ $userEmail }}</dd></div>
        </div>
        <div class="pf-fact">
          <span class="pf-fact-ico"><img src="{{ asset('image/c2889.svg') }}" width="12" height="15" alt="" /></span>
          <div><dt class="pj-bold">Lokasi</dt><dd class="in-med">{{ $userKota }}{{ $userProv ? ', ' . $userProv : '' }}</dd></div>
        </div>
        <div class="pf-fact">
          <span class="pf-fact-ico"><img src="{{ asset('image/de02b.svg') }}" width="18.3333" height="13.3333" alt="" /></span>
          <div><dt class="pj-bold">Gender</dt><dd class="in-med">{{ $userGender }}</dd></div>
        </div>
        <div class="pf-fact">
          <span class="pf-fact-ico"><img src="{{ asset('image/f4631.svg') }}" width="16.5" height="13.5" alt="" /></span>
          <div><dt class="pj-bold">Program Studi</dt><dd class="in-med">{{ $userProdi }}</dd></div>
        </div>
        <div class="pf-fact">
          <span class="pf-fact-ico"><img src="{{ asset('image/09420.svg') }}" width="18.3333" height="13.3333" alt="" /></span>
          <div><dt class="pj-bold">Bidang Minat</dt><dd class="in-med">{{ $userMinatText }}</dd></div>
        </div>
      </dl>

      <form action="{{ route('logout') }}" method="POST" style="margin-top:24px;width:100%">
        @csrf
        <button class="pj-semi" type="submit" onclick="return confirm('Apakah Anda yakin ingin keluar?')" style="width:100%;display:flex;align-items:center;justify-content:center;gap:8px;padding:11px 16px;background:#fff1f0;color:#cf1322;border:1px solid #ffa39e;border-radius:12px;font-size:14px;cursor:pointer;font-weight:600;transition:all 0.2s">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
            <polyline points="16 17 21 12 16 7"></polyline>
            <line x1="21" y1="12" x2="9" y2="12"></line>
          </svg>
          <span>Keluar Akun (Logout)</span>
        </button>
      </form>
    </section>

    {{-- KONTEN KANAN: Panel View (Default) --}}
    <section class="pf-card" id="panel-view-profile" style="display:{{ $hasErrors ? 'none' : 'block' }}" aria-label="Informasi profil">
      <div class="pf-form-head">
        <h2 class="jd-h2 pj-bold">Informasi Profil</h2>
        <span class="pf-tag pj-bold">Tersimpan</span>
      </div>
      <p class="jd-sub in-reg" style="padding-top:2px">Data identitas dan preferensi belajarmu di StudyMate.</p>

      <div class="pf-fields" style="padding-top:16px">
        <div class="jd-field">
          <span class="jd-label pj-semi">Nama Lengkap</span>
          <div class="jd-control">
            <span class="lead-ico"><img src="{{ asset('image/186b4.svg') }}" width="13.3333" height="13.3333" alt="" /></span>
            <input class="jd-input" type="text" value="{{ $userName }}" readonly style="background:#f8f9fc;cursor:default;color:#1c1b1f" />
          </div>
        </div>

        <div class="jd-field">
          <span class="jd-label pj-semi">Email <span style="font-size:11px;color:#888;font-weight:400">(tidak dapat diubah)</span></span>
          <div class="jd-control">
            <span class="lead-ico"><img src="{{ asset('image/d2740.svg') }}" width="16.6667" height="13.3333" alt="" /></span>
            <input class="jd-input" type="text" value="{{ $userEmail }}" readonly style="background:#f8f9fc;cursor:default;color:#1c1b1f" />
          </div>
        </div>

        <div class="jd-field">
          <span class="jd-label pj-semi">Jenis Kelamin (Gender)</span>
          <div class="jd-control">
            <span class="lead-ico"><img src="{{ asset('image/de02b.svg') }}" width="18.3333" height="13.3333" alt="" /></span>
            <input class="jd-input" type="text" value="{{ $userGender }}" readonly style="background:#f8f9fc;cursor:default;color:#1c1b1f" />
          </div>
        </div>

        <div class="jd-field">
          <span class="jd-label pj-semi">Lokasi (Kota &amp; Provinsi)</span>
          <div class="jd-control">
            <span class="lead-ico"><img src="{{ asset('image/0d9bf.svg') }}" width="13.3333" height="16.6667" alt="" /></span>
            <input class="jd-input" type="text" value="{{ $userKota }}{{ $userProv ? ', ' . $userProv : '' }}" readonly style="background:#f8f9fc;cursor:default;color:#1c1b1f" />
          </div>
        </div>

        <div class="jd-field">
          <span class="jd-label pj-semi">Program Studi</span>
          <div class="jd-control">
            <span class="lead-ico"><img src="{{ asset('image/4f138.svg') }}" width="18.3333" height="15" alt="" /></span>
            <input class="jd-input" type="text" value="{{ $userProdi }}" readonly style="background:#f8f9fc;cursor:default;color:#1c1b1f" />
          </div>
        </div>

        <div class="jd-field">
          <span class="jd-label pj-semi">Bidang Minat</span>
          <div class="jd-control">
            <span class="lead-ico"><img src="{{ asset('image/09420.svg') }}" width="18.3333" height="13.3333" alt="" /></span>
            <input class="jd-input" type="text" value="{{ $userMinatText }}" readonly style="background:#f8f9fc;cursor:default;color:#1c1b1f" />
          </div>
        </div>

        <p class="pf-note in-reg">
          <img src="{{ asset('image/b400e.svg') }}" width="12" height="17" alt="" />
          Informasimu digunakan untuk rekomendasi teman dan kelompok belajar di StudyMate.
        </p>
      </div>
    </section>

    {{-- KONTEN KANAN: Form Edit Profil (Muncul saat tombol Edit ditekan) --}}
    <form class="pf-card" id="panel-edit-profile" action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data" novalidate style="display:{{ $hasErrors ? 'block' : 'none' }}">
      @csrf

      {{-- File input tersembunyi untuk foto --}}
      <input type="file" id="foto_profil" name="foto_profil" accept="image/png,image/jpeg,image/webp" style="display:none" />

      <div class="pf-form-head">
        <h2 class="jd-h2 pj-bold">Edit Informasi Akun</h2>
        <span class="pf-tag pj-bold">Form Edit</span>
      </div>
      <p class="jd-sub in-reg" style="padding-top:2px">Ubah data profil sesuai dengan identitas terbarumu.</p>

      <div class="pf-fields" style="padding-top:16px">
        {{-- Nama Lengkap --}}
        <div class="jd-field">
          <label class="jd-label pj-semi" for="nama">Nama Lengkap <span class="req" style="color:#ad2f34">*</span></label>
          <div class="jd-control">
            <span class="lead-ico"><img src="{{ asset('image/186b4.svg') }}" width="13.3333" height="13.3333" alt="" /></span>
            <input class="jd-input @error('nama') is-invalid @enderror" id="nama" name="nama" type="text" placeholder="Masukkan nama lengkap" value="{{ $editNama }}" maxlength="100" />
          </div>
          <span class="field-error-msg" id="nama-error" style="display:{{ $errors->has('nama') ? 'block' : 'none' }}">
            {{ $errors->first('nama') ?: 'Data tidak boleh kosong.' }}
          </span>
        </div>

        {{-- Email (Read-only) --}}
        <div class="jd-field">
          <label class="jd-label pj-semi" for="email">Email <span style="font-size:11px;color:#888;font-weight:400">(tidak dapat diubah)</span></label>
          <div class="jd-control">
            <span class="lead-ico"><img src="{{ asset('image/d2740.svg') }}" width="16.6667" height="13.3333" alt="" /></span>
            <input class="jd-input" id="email" type="email" value="{{ $userEmail }}" readonly style="background:#f4f5f8;color:#666;cursor:not-allowed" />
          </div>
        </div>

        {{-- Gender --}}
        <div class="jd-field">
          <label class="jd-label pj-semi" for="gender">Jenis Kelamin <span class="req" style="color:#ad2f34">*</span></label>
          <div class="jd-control">
            <span class="lead-ico"><img src="{{ asset('image/de02b.svg') }}" width="18.3333" height="13.3333" alt="" /></span>
            <select class="jd-input @error('gender') is-invalid @enderror" id="gender" name="gender">
              <option value="">Pilih jenis kelamin...</option>
              <option value="Laki-laki" {{ $editGender === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
              <option value="Perempuan" {{ $editGender === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
            <img class="chev" src="{{ asset('image/754a3.svg') }}" width="10" height="6.16667" alt="" />
          </div>
          <span class="field-error-msg" id="gender-error" style="display:{{ $errors->has('gender') ? 'block' : 'none' }}">
            {{ $errors->first('gender') ?: 'Data tidak boleh kosong.' }}
          </span>
        </div>

        {{-- Lokasi Domisili: Provinsi & Kota --}}
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px">
          <div class="jd-field">
            <label class="jd-label pj-semi" for="provinsi">Provinsi <span class="req" style="color:#ad2f34">*</span></label>
            <div class="jd-control">
              <span class="lead-ico"><img src="{{ asset('image/0d9bf.svg') }}" width="13.3333" height="16.6667" alt="" /></span>
              <select class="jd-input @error('provinsi') is-invalid @enderror" id="provinsi" name="provinsi">
                <option value="">Memuat provinsi...</option>
              </select>
              <img class="chev" src="{{ asset('image/754a3.svg') }}" width="10" height="6.16667" alt="" />
            </div>
            <span class="field-error-msg" id="provinsi-error" style="display:{{ $errors->has('provinsi') ? 'block' : 'none' }}">
              {{ $errors->first('provinsi') ?: 'Data tidak boleh kosong.' }}
            </span>
          </div>

          <div class="jd-field">
            <label class="jd-label pj-semi" for="kota">Kota / Kabupaten <span class="req" style="color:#ad2f34">*</span></label>
            <div class="jd-control">
              <span class="lead-ico"><img src="{{ asset('image/0d9bf.svg') }}" width="13.3333" height="16.6667" alt="" /></span>
              <select class="jd-input @error('kota') is-invalid @enderror" id="kota" name="kota">
                <option value="">Pilih provinsi dulu...</option>
              </select>
              <img class="chev" src="{{ asset('image/754a3.svg') }}" width="10" height="6.16667" alt="" />
            </div>
            <span class="field-error-msg" id="kota-error" style="display:{{ $errors->has('kota') ? 'block' : 'none' }}">
              {{ $errors->first('kota') ?: 'Data tidak boleh kosong.' }}
            </span>
          </div>
        </div>

        {{-- Program Studi --}}
        <div class="jd-field" style="margin-top:8px">
          <label class="jd-label pj-semi">Program Studi <span class="req" style="color:#ad2f34">*</span></label>
          <div class="chips f-medium" id="prodi-chips" style="display:flex;flex-wrap:wrap;gap:8px;margin-top:6px">
            @foreach ($jurusans as $j)
              <label class="chip">
                <input type="radio" name="prodi" value="{{ $j }}" {{ ($editProdi === $j && !$isOtherProdiSelected) ? 'checked' : '' }} />
                <span>{{ $j }}</span>
              </label>
            @endforeach
            <label class="chip">
              <input type="radio" id="prodi_other_radio" name="prodi" value="Other" {{ $isOtherProdiSelected ? 'checked' : '' }} />
              <span>Other</span>
            </label>
          </div>
          <span class="field-error-msg" id="prodi-error" style="display:{{ $errors->has('prodi') && !$isOtherProdiSelected ? 'block' : 'none' }}">
            {{ $errors->first('prodi') ?: 'Data tidak boleh kosong.' }}
          </span>

          {{-- Input prodi_other jika Other dipilih --}}
          <div id="prodi-other-container" style="{{ $isOtherProdiSelected ? 'display:block;' : 'display:none;' }}margin-top:10px">
            <div class="jd-control">
              <span class="lead-ico"><img src="{{ asset('image/4f138.svg') }}" width="18.3333" height="15" alt="" /></span>
              <input class="jd-input @error('prodi_other') is-invalid @enderror" id="prodi_other" name="prodi_other" type="text" placeholder="Tuliskan nama program studi Anda..." value="{{ $prodiOtherValue }}" maxlength="100" />
            </div>
            <span class="field-error-msg" id="prodi-other-error" style="display:{{ $errors->has('prodi') && $isOtherProdiSelected ? 'block' : 'none' }}">
              {{ $errors->first('prodi') ?: 'Data tidak boleh kosong.' }}
            </span>
          </div>
        </div>

        {{-- Bidang Minat (1-3 pilihan) --}}
        <div class="jd-field" style="margin-top:8px">
          <div style="display:flex;align-items:center;justify-content:space-between">
            <label class="jd-label pj-semi">Bidang Minat <span class="req" style="color:#ad2f34">*</span></label>
            <span id="minat-count-text" style="font-size:12px;color:#3525cd;font-weight:600">
              {{ count($selectedMinat) }} dipilih (Maks. 3)
            </span>
          </div>

          <div class="topics" style="display:grid;grid-template-columns:repeat(auto-fill, minmax(200px, 1fr));gap:10px;margin-top:8px">
            @foreach ($topics as $t)
              @php $isChecked = in_array($t['name'], $selectedMinat); @endphp
              <label class="topic-item">
                <input type="checkbox" name="minat[]" value="{{ $t['name'] }}" {{ $isChecked ? 'checked' : '' }} />
                <span class="topic-card f-medium" style="padding:10px 12px">
                  <span class="topic-main">
                    <span class="topic-icon">
                      <img src="{{ asset('image/' . $t['icon']) }}" width="{{ $t['w'] }}" height="{{ $t['h'] }}" alt="" />
                    </span>
                    <span style="font-size:13px">{{ $t['name'] }}</span>
                  </span>
                  <span class="topic-check">
                    <img class="on" src="{{ asset('image/e0f80.svg') }}" width="12" height="9" alt="" />
                    <img class="off" src="{{ asset('image/0bb8c.svg') }}" width="20" height="20" alt="" />
                  </span>
                </span>
              </label>
            @endforeach

            {{-- Chip Other untuk minat --}}
            @php $isMinatOtherChecked = in_array('Other', $selectedMinat); @endphp
            <label class="topic-item">
              <input type="checkbox" id="minat_other_checkbox" name="minat[]" value="Other" {{ $isMinatOtherChecked ? 'checked' : '' }} />
              <span class="topic-card f-medium" style="padding:10px 12px">
                <span class="topic-main">
                  <span class="topic-icon">
                    <img src="{{ asset('image/3161c.svg') }}" width="15" height="15" alt="" />
                  </span>
                  <span style="font-size:13px">Other (Lainnya)</span>
                </span>
                <span class="topic-check">
                  <img class="on" src="{{ asset('image/e0f80.svg') }}" width="12" height="9" alt="" />
                  <img class="off" src="{{ asset('image/0bb8c.svg') }}" width="20" height="20" alt="" />
                </span>
              </span>
            </label>
          </div>

          <span class="field-error-msg" id="minat-error" style="display:{{ $errors->has('minat') ? 'block' : 'none' }}">
            {{ $errors->first('minat') ?: 'Data tidak boleh kosong.' }}
          </span>

          {{-- Input minat_other jika Other dicentang --}}
          <div id="minat-other-container" style="{{ $isMinatOtherChecked ? 'display:block;' : 'display:none;' }}margin-top:10px">
            <div class="jd-control">
              <span class="lead-ico"><img src="{{ asset('image/09420.svg') }}" width="18.3333" height="13.3333" alt="" /></span>
              <input class="jd-input @error('minat_other') is-invalid @enderror" id="minat_other" name="minat_other" type="text" placeholder="Tuliskan bidang minat Anda..." value="{{ $selectedMinatOther }}" maxlength="50" />
            </div>
            <span class="field-error-msg" id="minat-other-error" style="display:{{ $errors->has('minat_other') ? 'block' : 'none' }}">
              {{ $errors->first('minat_other') ?: 'Data tidak boleh kosong.' }}
            </span>
          </div>
        </div>
      </div>

      {{-- Action Buttons --}}
      <div class="pf-actions pj-semi" style="padding-top:24px;display:flex;justify-content:flex-end;gap:12px">
        <button class="pf-cancel" id="btn-cancel-edit" type="button" style="cursor:pointer">
          Batalkan
        </button>
        <button class="pf-save" type="submit" style="cursor:pointer;border:none">
          <img src="{{ asset('image/292d3.svg') }}" width="12.225" height="9.01875" alt="" />
          <span>Simpan Perubahan</span>
        </button>
      </div>
    </form>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // 1. Toggle Mode View vs Edit dalam 1 halaman
      var panelView = document.getElementById('panel-view-profile');
      var panelEdit = document.getElementById('panel-edit-profile');
      var btnToggle = document.getElementById('btn-toggle-edit');
      var btnToggleText = document.getElementById('btn-toggle-text');
      var btnCancel = document.getElementById('btn-cancel-edit');
      var mainHeading = document.getElementById('page-main-heading');
      var subHeading = document.getElementById('page-sub-heading');
      var avatarBtnWrap = document.getElementById('avatar-btn-wrap');

      function showEditMode() {
        panelView.style.display = 'none';
        panelEdit.style.display = 'block';
        btnToggleText.textContent = 'Batal Edit';
        mainHeading.textContent = 'Edit Profil Belajar';
        subHeading.textContent = 'Perbarui identitas dan preferensi belajarmu';
        avatarBtnWrap.style.display = 'block';
      }

      function showViewMode() {
        panelEdit.style.display = 'none';
        panelView.style.display = 'block';
        btnToggleText.textContent = 'Edit Profil';
        mainHeading.textContent = 'Profil Belajar';
        subHeading.textContent = 'Kelola profil dan preferensi akunmu';
        avatarBtnWrap.style.display = 'none';
      }

      btnToggle.addEventListener('click', function() {
        if (panelEdit.style.display === 'none' || panelEdit.style.display === '') {
          showEditMode();
        } else {
          showViewMode();
        }
      });

      btnCancel.addEventListener('click', function() {
        showViewMode();
      });

      // 2. Preview & Crop Foto Profil
      var fotoInput = document.getElementById('foto_profil');
      var avatarImg = document.getElementById('profile-avatar-img');
      var avatarErr = document.getElementById('avatar-error');
      var cropModal = document.getElementById('modal-crop');
      var cropImageEl = document.getElementById('crop-image-element');
      var btnCropSave = document.getElementById('btn-crop-save');
      var btnCropCancel = document.getElementById('btn-crop-cancel');
      var cropper = null;
      var originalFileName = 'avatar.png';

      fotoInput.addEventListener('change', function(e) {
        if (avatarErr) avatarErr.style.display = 'none';

        if (e.target.files && e.target.files[0]) {
          var file = e.target.files[0];

          // Validasi ukuran file asli (maksimal 2MB = 2 * 1024 * 1024 bytes)
          if (file.size > 2 * 1024 * 1024) {
            fotoInput.value = '';
            if (avatarErr) {
              avatarErr.textContent = 'Ukuran file foto maksimal 2MB.';
              avatarErr.style.display = 'block';
            }
            return;
          }

          originalFileName = file.name || 'avatar.png';
          var reader = new FileReader();
          reader.onload = function(evt) {
            cropImageEl.src = evt.target.result;
            cropModal.style.display = 'flex';

            if (cropper) {
              cropper.destroy();
            }

            cropper = new Cropper(cropImageEl, {
              aspectRatio: 1,
              viewMode: 1,
              dragMode: 'move',
              autoCropArea: 0.9,
              restore: false,
              guides: true,
              center: true,
              highlight: false,
              cropBoxMovable: true,
              cropBoxResizable: true,
              toggleDragModeOnDblclick: false,
            });
          };
          reader.readAsDataURL(file);
        }
      });

      btnCropCancel.addEventListener('click', function() {
        cropModal.style.display = 'none';
        if (cropper) {
          cropper.destroy();
          cropper = null;
        }
        fotoInput.value = '';
      });

      btnCropSave.addEventListener('click', function() {
        if (!cropper) return;

        var canvas = cropper.getCroppedCanvas({
          width: 500,
          height: 500,
          imageSmoothingEnabled: true,
          imageSmoothingQuality: 'high',
        });

        canvas.toBlob(function(blob) {
          if (!blob) return;

          // Buat file baru dari blob hasil crop untuk dimasukkan ke form file input
          var croppedFile = new File([blob], originalFileName, {
            type: blob.type || 'image/png',
            lastModified: Date.now()
          });

          var dataTransfer = new DataTransfer();
          dataTransfer.items.add(croppedFile);
          fotoInput.files = dataTransfer.files;

          // Perbarui foto avatar preview di UI
          avatarImg.src = canvas.toDataURL('image/png');

          // Tutup modal
          cropModal.style.display = 'none';
          cropper.destroy();
          cropper = null;
        }, 'image/png');
      });

      // 3. Wilayah API (Provinsi & Kota)
      var provSelect = document.getElementById('provinsi');
      var kotaSelect = document.getElementById('kota');
      var initialProv = @json($editProv);
      var initialKota = @json($editKota);

      function normalize(str) {
        return (str || '').toString().trim().toLowerCase();
      }

      fetch('/api/wilayah/provinces')
        .then(function(r) { return r.json(); })
        .then(function(res) {
          if (!res || !res.data) return;
          provSelect.innerHTML = '<option value="">Pilih provinsi...</option>';
          res.data.sort(function(a, b) { return a.name.localeCompare(b.name); });
          var selectedCode = null;
          res.data.forEach(function(p) {
            var opt = document.createElement('option');
            opt.value = p.name;
            opt.dataset.code = p.code;
            opt.textContent = p.name;
            if (normalize(p.name) === normalize(initialProv)) {
              opt.selected = true;
              selectedCode = p.code;
            }
            provSelect.appendChild(opt);
          });
          if (selectedCode) {
            loadKota(selectedCode, initialKota);
          } else {
            kotaSelect.innerHTML = '<option value="">Pilih provinsi dulu...</option>';
          }
        })
        .catch(function(err) {
          console.error('Gagal mengambil data provinsi:', err);
          provSelect.innerHTML = '<option value="">Gagal memuat provinsi</option>';
        });

      function loadKota(provinceCode, selectKotaName) {
        kotaSelect.disabled = true;
        kotaSelect.innerHTML = '<option value="">Memuat kota / kabupaten...</option>';
        fetch('/api/wilayah/regencies/' + encodeURIComponent(provinceCode))
          .then(function(r) { return r.json(); })
          .then(function(res) {
            kotaSelect.innerHTML = '<option value="">Pilih kota / kabupaten...</option>';
            if (res && res.data) {
              res.data.sort(function(a, b) { return a.name.localeCompare(b.name); });
              res.data.forEach(function(k) {
                var opt = document.createElement('option');
                opt.value = k.name;
                opt.textContent = k.name;
                if (selectKotaName && normalize(k.name) === normalize(selectKotaName)) {
                  opt.selected = true;
                }
                kotaSelect.appendChild(opt);
              });
            }
            kotaSelect.disabled = false;
          })
          .catch(function(err) {
            console.error('Gagal mengambil data kota:', err);
            kotaSelect.innerHTML = '<option value="">Gagal memuat kota</option>';
            kotaSelect.disabled = false;
          });
      }

      provSelect.addEventListener('change', function() {
        var sel = provSelect.options[provSelect.selectedIndex];
        var code = sel ? sel.dataset.code : null;
        if (code) {
          loadKota(code, null);
        } else {
          kotaSelect.innerHTML = '<option value="">Pilih provinsi dulu...</option>';
        }
      });

      // 4. Prodi Radio & Other
      var prodiRadios = document.querySelectorAll('input[name="prodi"]');
      var prodiOtherRadio = document.getElementById('prodi_other_radio');
      var prodiOtherContainer = document.getElementById('prodi-other-container');
      var prodiOtherInput = document.getElementById('prodi_other');
      var prodiErr = document.getElementById('prodi-error');
      var prodiOtherErr = document.getElementById('prodi-other-error');

      function toggleProdiOther() {
        if (prodiOtherRadio.checked) {
          prodiOtherContainer.style.display = 'block';
          prodiOtherInput.focus();
        } else {
          prodiOtherContainer.style.display = 'none';
          prodiOtherInput.classList.remove('is-invalid');
          prodiOtherErr.style.display = 'none';
        }
      }

      prodiRadios.forEach(function(r) {
        r.addEventListener('change', function() {
          toggleProdiOther();
          prodiErr.style.display = 'none';
        });
      });

      // 5. Minat Checkboxes & Other (Max 3)
      var minatCheckboxes = document.querySelectorAll('input[name="minat[]"]');
      var minatOtherCheckbox = document.getElementById('minat_other_checkbox');
      var minatOtherContainer = document.getElementById('minat-other-container');
      var minatOtherInput = document.getElementById('minat_other');
      var minatCountText = document.getElementById('minat-count-text');
      var minatErr = document.getElementById('minat-error');
      var minatOtherErr = document.getElementById('minat-other-error');

      function updateMinatCount() {
        var checked = document.querySelectorAll('input[name="minat[]"]:checked');
        minatCountText.textContent = checked.length + ' dipilih (Maks. 3)';
        if (checked.length > 0) {
          minatErr.style.display = 'none';
        }
      }

      function toggleMinatOther() {
        if (minatOtherCheckbox.checked) {
          minatOtherContainer.style.display = 'block';
          minatOtherInput.focus();
        } else {
          minatOtherContainer.style.display = 'none';
          minatOtherInput.classList.remove('is-invalid');
          minatOtherErr.style.display = 'none';
        }
      }

      minatCheckboxes.forEach(function(cb) {
        cb.addEventListener('change', function() {
          var checked = document.querySelectorAll('input[name="minat[]"]:checked');
          if (checked.length > 3) {
            cb.checked = false;
            alert('Maksimal memilih 3 bidang minat.');
            return;
          }
          if (cb === minatOtherCheckbox) {
            toggleMinatOther();
          }
          updateMinatCount();
        });
      });

      // 6. Validasi Realtime Blur / Change (Pesan Seragam "Data tidak boleh kosong.")
      var namaInput = document.getElementById('nama');
      var namaErr = document.getElementById('nama-error');
      var genderSelect = document.getElementById('gender');
      var genderErr = document.getElementById('gender-error');
      var provErr = document.getElementById('provinsi-error');
      var kotaErr = document.getElementById('kota-error');

      namaInput.addEventListener('blur', function() {
        if (!this.value.trim()) {
          this.classList.add('is-invalid');
          namaErr.textContent = 'Data tidak boleh kosong.';
          namaErr.style.display = 'block';
        }
      });
      namaInput.addEventListener('input', function() {
        if (this.value.trim()) {
          this.classList.remove('is-invalid');
          namaErr.style.display = 'none';
        }
      });

      genderSelect.addEventListener('change', function() {
        if (this.value) {
          this.classList.remove('is-invalid');
          genderErr.style.display = 'none';
        }
      });
      genderSelect.addEventListener('blur', function() {
        if (!this.value) {
          this.classList.add('is-invalid');
          genderErr.textContent = 'Data tidak boleh kosong.';
          genderErr.style.display = 'block';
        }
      });

      provSelect.addEventListener('change', function() {
        if (this.value) {
          this.classList.remove('is-invalid');
          provErr.style.display = 'none';
        }
      });
      provSelect.addEventListener('blur', function() {
        if (!this.value) {
          this.classList.add('is-invalid');
          provErr.textContent = 'Data tidak boleh kosong.';
          provErr.style.display = 'block';
        }
      });

      kotaSelect.addEventListener('change', function() {
        if (this.value) {
          this.classList.remove('is-invalid');
          kotaErr.style.display = 'none';
        }
      });
      kotaSelect.addEventListener('blur', function() {
        if (!this.value) {
          this.classList.add('is-invalid');
          kotaErr.textContent = 'Data tidak boleh kosong.';
          kotaErr.style.display = 'block';
        }
      });

      prodiOtherInput.addEventListener('input', function() {
        if (this.value.trim()) {
          this.classList.remove('is-invalid');
          prodiOtherErr.style.display = 'none';
        }
      });
      prodiOtherInput.addEventListener('blur', function() {
        if (prodiOtherRadio.checked && !this.value.trim()) {
          this.classList.add('is-invalid');
          prodiOtherErr.textContent = 'Data tidak boleh kosong.';
          prodiOtherErr.style.display = 'block';
        }
      });

      minatOtherInput.addEventListener('input', function() {
        if (this.value.trim()) {
          this.classList.remove('is-invalid');
          minatOtherErr.style.display = 'none';
        }
      });
      minatOtherInput.addEventListener('blur', function() {
        if (minatOtherCheckbox.checked && !this.value.trim()) {
          this.classList.add('is-invalid');
          minatOtherErr.textContent = 'Data tidak boleh kosong.';
          minatOtherErr.style.display = 'block';
        }
      });

      // 7. Intercept Submit Form: Cek Kosong Semua Field
      var form = document.getElementById('panel-edit-profile');
      form.addEventListener('submit', function(e) {
        var isValid = true;
        var firstInvalid = null;

        // Validasi Nama
        if (!namaInput.value.trim()) {
          isValid = false;
          namaInput.classList.add('is-invalid');
          namaErr.textContent = 'Data tidak boleh kosong.';
          namaErr.style.display = 'block';
          if (!firstInvalid) firstInvalid = namaInput;
        }

        // Validasi Gender
        if (!genderSelect.value) {
          isValid = false;
          genderSelect.classList.add('is-invalid');
          genderErr.textContent = 'Data tidak boleh kosong.';
          genderErr.style.display = 'block';
          if (!firstInvalid) firstInvalid = genderSelect;
        }

        // Validasi Provinsi
        if (!provSelect.value) {
          isValid = false;
          provSelect.classList.add('is-invalid');
          provErr.textContent = 'Data tidak boleh kosong.';
          provErr.style.display = 'block';
          if (!firstInvalid) firstInvalid = provSelect;
        }

        // Validasi Kota
        if (!kotaSelect.value) {
          isValid = false;
          kotaSelect.classList.add('is-invalid');
          kotaErr.textContent = 'Data tidak boleh kosong.';
          kotaErr.style.display = 'block';
          if (!firstInvalid) firstInvalid = kotaSelect;
        }

        // Validasi Prodi
        var selectedProdi = document.querySelector('input[name="prodi"]:checked');
        if (!selectedProdi) {
          isValid = false;
          prodiErr.textContent = 'Data tidak boleh kosong.';
          prodiErr.style.display = 'block';
          if (!firstInvalid) firstInvalid = document.getElementById('prodi-chips');
        } else if (selectedProdi.value === 'Other' && !prodiOtherInput.value.trim()) {
          isValid = false;
          prodiOtherInput.classList.add('is-invalid');
          prodiOtherErr.textContent = 'Data tidak boleh kosong.';
          prodiOtherErr.style.display = 'block';
          if (!firstInvalid) firstInvalid = prodiOtherInput;
        }

        // Validasi Minat
        var checkedMinat = document.querySelectorAll('input[name="minat[]"]:checked');
        if (checkedMinat.length === 0) {
          isValid = false;
          minatErr.textContent = 'Data tidak boleh kosong.';
          minatErr.style.display = 'block';
          if (!firstInvalid) firstInvalid = document.querySelector('.topics');
        } else if (minatOtherCheckbox.checked && !minatOtherInput.value.trim()) {
          isValid = false;
          minatOtherInput.classList.add('is-invalid');
          minatOtherErr.textContent = 'Data tidak boleh kosong.';
          minatOtherErr.style.display = 'block';
          if (!firstInvalid) firstInvalid = minatOtherInput;
        }

        if (!isValid) {
          e.preventDefault();
          if (firstInvalid && firstInvalid.scrollIntoView) {
            firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
            if (firstInvalid.focus) firstInvalid.focus();
          }
        }
      });
    });
  </script>

  {{-- Modal Crop Foto Profil --}}
  <div class="modal-crop-backdrop" id="modal-crop">
    <div class="modal-crop-box">
      <div class="modal-crop-head">
        <h3 class="modal-crop-title pj-bold">Sesuaikan Foto Profil</h3>
      </div>
      <div class="modal-crop-body">
        <img id="crop-image-element" src="" alt="Pratinjau Foto" />
      </div>
      <div class="modal-crop-foot">
        <button type="button" class="btn-crop-cancel pj-semi" id="btn-crop-cancel">Batal</button>
        <button type="button" class="btn-crop-save pj-semi" id="btn-crop-save">Gunakan Foto</button>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
@endsection
