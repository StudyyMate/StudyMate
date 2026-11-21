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
    @forelse ($threads as $thread)
      <li>
        <a class="thread" href="{{ route('chat-room', $thread) }}">
          <span class="av"><img src="{{ $thread->foto_profil ? asset('storage/'.$thread->foto_profil) : asset('image/avatar-default.svg') }}" class="cover" alt="{{ $thread->nama }}" /></span>
          <div class="t-body">
            <p class="t-name pj-bold">{{ $thread->nama }}</p>
            <p class="t-major pj-med">{{ $thread->prodi }}</p>
            <p class="t-meta pj-med">{{ $thread->lokasi['kota'] ?? '-' }} &middot; {{ $thread->gender }}</p>
            <p class="t-msg pj-med">{{ $thread->last_message?->pesan ?? 'Mulai percakapan' }}</p>
          </div>
          <div class="t-side"><span class="t-time pj-semi">{{ $thread->last_message?->waktu_kirim?->format('H.i') ?? '' }}</span></div>
        </a>
      </li>
    @empty
      <li class="conv-empty">Belum ada percakapan.</li>
    @endforelse
  </ul>
@endsection
