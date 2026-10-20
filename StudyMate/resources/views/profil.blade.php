@extends('layouts.app')

@section('title', 'Profil Belajar')
@section('page-class', 'profil-page')
@section('main-class', 'pf-main')

@section('content')
  @php
    $u = Auth::user();
    $userName   = $u->nama ?? 'Komang Andini';
    $userEmail  = $u->email ?? 'komangutami@gmail.com';
    $userProdi  = $u->prodi ?? 'Informatika';
    $userStreak = $u->streak ?? 7;
    $userGender = $u->gender ?? 'Perempuan';
    $userMinat  = $u->bidang_diminati ?? 'Software Engineering';

    if (is_array($u?->lokasi)) {
      $userKota = $u->lokasi['kota'] ?? 'Surabaya';
      $userProv = $u->lokasi['provinsi'] ?? 'Jawa Timur';
    } else {
      $userKota = $u?->lokasi ?? 'Surabaya';
      $userProv = '';
    }
  @endphp

  <div class="pf-head">
    <div>
      <h1 class="pf-title pj-xbold">Profil Belajar</h1>
      <p class="jd-sub in-reg">Kelola profil dan preferensi akunmu</p>
    </div>
    <div style="display:flex;align-items:center;gap:10px">
      <a class="pf-edit pj-semi" href="#informasi">
        <img src="{{ asset('image/49219.svg') }}" width="13.5" height="13.5" alt="" />Edit Profil
      </a>
      <form action="{{ route('logout') }}" method="POST" style="margin:0">
        @csrf
        <button class="pf-edit pj-semi" type="submit" onclick="return confirm('Apakah Anda yakin ingin keluar?')" style="background:#fff1f0;color:#cf1322;border:1px solid #ffa39e;cursor:pointer">
          <svg width="13.5" height="13.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
            <polyline points="16 17 21 12 16 7"></polyline>
            <line x1="21" y1="12" x2="9" y2="12"></line>
          </svg>
          Logout
        </button>
      </form>
    </div>
  </div>

  <div class="pf-grid">
    <section class="pf-card pf-summary" aria-label="Ringkasan profil">
      <div class="pf-avatar">
        <img src="{{ asset('image/fc5ce.png') }}" alt="Foto {{ $userName }}" />
        <span class="pf-online" aria-label="Online"></span>
      </div>
      <h2 class="pf-name pj-bold">{{ $userName }}</h2>
      <p class="pf-sub pj-semi">{{ $userProdi }} &bull; {{ $userKota }}</p>

      <div class="pf-badges pj-semi">
        <span class="pf-badge streak">
          <img src="{{ asset('image/65d39.svg') }}" width="8.66667" height="10.2917" alt="" />{{ $userStreak }} Hari Streak
        </span>
        <span class="pf-badge verified">
          <img src="{{ asset('image/0e494.svg') }}" width="11.9167" height="11.375" alt="" />Terverifikasi
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
          <span class="pf-fact-ico"><img src="{{ asset('image/f4631.svg') }}" width="16.5" height="13.5" alt="" /></span>
          <div><dt class="pj-bold">Program Studi</dt><dd class="in-med">{{ $userProdi }}</dd></div>
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

    <form class="pf-card" id="informasi" action="#" method="post">
      @csrf
      <div class="pf-form-head">
        <h2 class="jd-h2 pj-bold">Informasi Profil</h2>
        <span class="pf-tag pj-bold">Preferensi</span>
      </div>
      <p class="jd-sub in-reg" style="padding-top:2px">Perbarui identitas dan preferensi belajarmu.</p>

      <div class="pf-fields">
        <div class="jd-field">
          <label class="jd-label pj-semi" for="nama">Nama Lengkap <span class="req">*</span></label>
          <div class="jd-control">
            <span class="lead-ico"><img src="{{ asset('image/186b4.svg') }}" width="13.3333" height="13.3333" alt="" /></span>
            <input class="jd-input" id="nama" name="nama" type="text" value="{{ $userName }}" required />
          </div>
        </div>

        <div class="jd-field">
          <label class="jd-label pj-semi" for="email">Email <span class="req">*</span></label>
          <div class="jd-control">
            <span class="lead-ico"><img src="{{ asset('image/d2740.svg') }}" width="16.6667" height="13.3333" alt="" /></span>
            <input class="jd-input" id="email" name="email" type="email" value="{{ $userEmail }}" required />
          </div>
        </div>

        <div class="jd-field">
          <label class="jd-label pj-semi" for="kota">Lokasi (Kota)</label>
          <div class="jd-control">
            <span class="lead-ico"><img src="{{ asset('image/0d9bf.svg') }}" width="13.3333" height="16.6667" alt="" /></span>
            <select class="jd-input" id="kota" name="kota">
              <option>Surabaya</option>
              <option>Malang</option>
              <option>Sidoarjo</option>
              <option>Bandung</option>
              <option>Yogyakarta</option>
              <option>Jakarta</option>
            </select>
            <img class="chev" src="{{ asset('image/754a3.svg') }}" width="10" height="6.16667" alt="" />
          </div>
        </div>

        <div class="jd-field">
          <label class="jd-label pj-semi" for="gender">Gender</label>
          <div class="jd-control">
            <span class="lead-ico"><img src="{{ asset('image/de02b.svg') }}" width="18.3333" height="13.3333" alt="" /></span>
            <select class="jd-input" id="gender" name="gender">
              <option>Perempuan</option>
              <option>Laki-laki</option>
            </select>
            <img class="chev" src="{{ asset('image/754a3.svg') }}" width="10" height="6.16667" alt="" />
          </div>
        </div>

        <div class="jd-field">
          <label class="jd-label pj-semi" for="prodi">Program Studi</label>
          <div class="jd-control">
            <span class="lead-ico"><img src="{{ asset('image/4f138.svg') }}" width="18.3333" height="15" alt="" /></span>
            <select class="jd-input" id="prodi" name="prodi">
              <option>Informatika</option>
              <option>Sistem Informasi</option>
              <option>Statistika</option>
              <option>Manajemen</option>
              <option>Kedokteran Gigi</option>
            </select>
            <img class="chev" src="{{ asset('image/754a3.svg') }}" width="10" height="6.16667" alt="" />
          </div>
        </div>

        <div class="jd-field">
          <label class="jd-label pj-semi" for="minat">Bidang yang Diminati</label>
          <div class="jd-control">
            <span class="lead-ico"><img src="{{ asset('image/09420.svg') }}" width="18.3333" height="13.3333" alt="" /></span>
            <select class="jd-input" id="minat" name="minat">
              <option>Database</option>
              <option>Software Engineering</option>
              <option>Artificial Intelligence</option>
              <option>UI/UX &amp; Product Design</option>
              <option>Cyber Security</option>
            </select>
            <img class="chev" src="{{ asset('image/754a3.svg') }}" width="10" height="6.16667" alt="" />
          </div>
        </div>

        <p class="pf-note in-reg">
          <img src="{{ asset('image/b400e.svg') }}" width="12" height="17" alt="" />
          Informasimu hanya digunakan untuk rekomendasi StudyMate.
        </p>
      </div>

      <div class="pf-actions pj-semi">
        <button class="pf-cancel" type="reset">Batalkan</button>
        <button class="pf-save" type="submit">
          <img src="{{ asset('image/292d3.svg') }}" width="12.225" height="9.01875" alt="" />
          <span>Simpan Perubahan</span>
        </button>
      </div>
    </form>
  </div>
@endsection
