@extends('layouts.app')

@section('title', 'Pesan & Percakapan')
@section('page-class', 'chat-page')
@section('main-class', 'chat-main')

@section('content')
  <h1 class="chat-title pj-xbold">Chat</h1>

  <label class="search">
    <img src="{{ asset('image/3bd7d.svg') }}" width="16" height="16" alt="" />
    <input type="search" name="q" placeholder="Cari teman..." aria-label="Cari teman" />
  </label>

  <ul class="threads">
    <li>
      <a class="thread unread" href="/chat-room?nama=Utami%20Putri">
        <span class="av"><img src="{{ asset('image/935bb.png') }}" class="cover" alt="Utami Putri" /></span>
        <div class="t-body">
          <p class="t-name pj-bold">Utami Putri</p>
          <p class="t-major pj-med">Informatika</p>
          <p class="t-meta pj-med">Surabaya &middot; Perempuan</p>
          <p class="t-msg pj-bold">Boleh, kita bahas besok besok ya!</p>
        </div>
        <div class="t-side">
          <span class="t-time pj-semi now">10.24</span>
          <span class="t-dot" aria-label="Belum dibaca"></span>
        </div>
      </a>
    </li>

    <li>
      <a class="thread unread" href="/chat-room?nama=Talitha%20Ameliya">
        <span class="av"><img src="{{ asset('image/ebb50.png') }}" class="cover" alt="Talitha Ameliya" /></span>
        <div class="t-body">
          <p class="t-name pj-bold">Talitha Ameliya</p>
          <p class="t-major pj-med">Informatika</p>
          <p class="t-meta pj-med">Surabaya &middot; Perempuan</p>
          <p class="t-msg pj-bold">Kabarin kalau besok kamu berangkat ya</p>
        </div>
        <div class="t-side">
          <span class="t-time pj-semi">09.15</span>
          <span class="t-dot" aria-label="Belum dibaca"></span>
        </div>
      </a>
    </li>

    <li>
      <a class="thread unread" href="/chat-room?nama=Anashtasya%20Aulia">
        <span class="av"><img src="{{ asset('image/3c045.png') }}" style="left:0.15%;top:-21.37%;width:100%;height:177.54%" alt="Anashtasya Aulia" /></span>
        <div class="t-body">
          <p class="t-name pj-bold">Anashtasya Aulia</p>
          <p class="t-major pj-med">Informatika</p>
          <p class="t-meta pj-med">Yogyakarta &middot; Perempuan</p>
          <p class="t-msg pj-bold">Kapan-kapan main ke Jogja kita ketemu ya</p>
        </div>
        <div class="t-side">
          <span class="t-time pj-semi">Kemarin</span>
          <span class="t-dot" aria-label="Belum dibaca"></span>
        </div>
      </a>
    </li>

    <li>
      <a class="thread" href="#chat-fairuzzahwa">
        <span class="av"><img src="{{ asset('image/1f2e8.png') }}" class="cover" alt="Fairuzzahwa" /></span>
        <div class="t-body">
          <p class="t-name pj-bold">Fairuzzahwa</p>
          <p class="t-major pj-med">Statistika</p>
          <p class="t-meta pj-med">Bandung &middot; Perempuan</p>
          <p class="t-msg pj-med">Tuker materi aja, biar saling belajar</p>
        </div>
        <div class="t-side">
          <span class="t-time pj-semi">Sen</span>
        </div>
      </a>
    </li>

    <li>
      <a class="thread" href="#chat-zainul-fikri">
        <span class="av"><img src="{{ asset('image/8fb29.png') }}" class="cover" alt="Zainul Fikri" /></span>
        <div class="t-body">
          <p class="t-name pj-bold">Zainul Fikri</p>
          <p class="t-major pj-med">Informatika</p>
          <p class="t-meta pj-med">Surabaya &middot; Laki-laki</p>
          <p class="t-msg pj-med">Terima kasih, catatannya membantu banget</p>
        </div>
        <div class="t-side">
          <span class="t-time pj-semi">Min</span>
        </div>
      </a>
    </li>
  </ul>
@endsection
