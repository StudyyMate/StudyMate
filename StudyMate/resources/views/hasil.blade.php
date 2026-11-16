@extends('layouts.app')

@section('title', 'Hasil Pencarian Teman Belajar')
@section('main-class', 'cari-main hasil-main')

@section('content')
  <div class="intro tight">
    <h1 class="page-title pj-xbold">Hasil Pencarian</h1>
    <p class="page-lead pj-med">Menampilkan teman belajar yang sesuai dengan kriteriamu.</p>
  </div>
  @if(!empty($filters))
    <div class="chips" id="chips">
      @foreach($filters as $key => $val)
        <a class="chip pj-semi" href="{{ route('cari') }}">{{ $val }} &times;</a>
      @endforeach
    </div>
  @endif

  @if(isset($results) && $results->count() > 0)
    <ul class="results recommendation-results" id="results">
      @foreach($results as $user)
        @php
          $uLokasi = is_array($user->lokasi) ? $user->lokasi : json_decode($user->lokasi ?? '[]', true);
          $uKota = $uLokasi['kota'] ?? ($uLokasi['provinsi'] ?? '-');
          $uMinat = $user->minat_list;
          $fotoUrl = $user->foto_profil ? asset('storage/' . $user->foto_profil) : asset('image/avatar-default.svg');
        @endphp
        <li class="card">
          <div class="card-top">
            <span class="av-44">
              <img class="cover" src="{{ $fotoUrl }}" alt="{{ $user->nama }}" onerror="this.onerror=null; this.src='{{ asset('image/avatar-default.svg') }}';" />
            </span>
            <div class="card-info">
              <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px;">
                <p class="c-name pj-bold">{{ $user->nama }}</p>
                @if(isset($user->similarity_score) && $user->similarity_score > 0)
                  <span class="pj-bold" style="font-size: 11px; background: #eef2ff; color: #3525cd; padding: 2px 8px; border-radius: 999px;">
                    {{ $user->similarity_score }}% Cocok
                  </span>
                @endif
              </div>
              <p class="c-major pj-med">{{ $user->prodi ?? 'Belum memilih prodi' }}</p>
              <p class="c-meta pj-med">
                <span><img src="{{ asset('image/14c4a.svg') }}" width="11" height="11" alt="" />{{ $uKota }}</span>
                <span><img src="{{ asset('image/30868.svg') }}" width="11" height="11" alt="" />{{ $user->gender ?? '-' }}</span>
              </p>
            </div>
          </div>
          <div class="card-foot">
            <div class="interests">
              @forelse(array_slice($uMinat, 0, 3) as $m)
                <span class="interest pj-bold">{{ $m }}</span>
              @empty
                <span class="interest pj-med" style="color: #888;">-</span>
              @endforelse
            </div>
            <a class="chat-btn pj-bold" href="{{ route('chat-room', ['partner' => $user->id_user]) }}">
              <img src="{{ asset('image/de1a9.svg') }}" width="11" height="11" alt="" />Chat
            </a>
          </div>
        </li>
      @endforeach
    </ul>
  @else
    {{-- Pesan empty-state sesuai spesifikasi Sprint 2 / user --}}
    <div style="text-align: center; padding: 48px 16px; background: #ffffff; border-radius: 12px; margin-top: 16px; border: 1px dashed #d1d5db;">
      <p class="pj-bold" style="font-size: 16px; color: #374151; margin-bottom: 8px;">User tidak tersedia / terdaftar</p>
      <p class="pj-med" style="color: #6b7280; margin: 0 0 16px 0;">Tidak ditemukan teman belajar yang cocok dengan kriteria pencarian ini.</p>
      <a href="{{ route('cari') }}" class="primary pj-bold" style="display: inline-block; padding: 8px 16px; background: #3525cd; color: #ffffff; border-radius: 8px; text-decoration: none; font-size: 13px;">
        Kembali ke Pencarian
      </a>
    </div>
  @endif
@endsection

@push('scripts')
  <script>
    // Dinamis dari backend, no client-side filtering needed
  </script>
@endpush
