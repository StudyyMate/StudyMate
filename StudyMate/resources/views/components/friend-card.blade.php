{{--
  components/friend-card.blade.php
  ================================
  Komponen kartu rekomendasi teman belajar.
  Props:
    - $name     : Nama teman (string)
    - $major    : Program studi (string)
    - $city     : Kota asal (string)
    - $gender   : Gender (string)
    - $photo    : Path foto avatar (string)
    - $photoStyle : Style khusus untuk avatar (opsional)
    - $tags     : Array tags keahlian / minat (array)
    - $chatUrl  : Tautan tombol chat (default: '/chat')
--}}
@props([
  'name' => 'Nama Teman',
  'major' => 'Informatika',
  'city' => 'Surabaya',
  'gender' => 'Perempuan',
  'photo' => '/image/935bb.png',
  'photoStyle' => null,
  'tags' => ['Database', 'SQL'],
  'chatUrl' => '/chat'
])

<article class="card friend">
  <div class="who">
    <span class="av av-44">
      <img src="{{ asset($photo) }}" @if($photoStyle) style="{{ $photoStyle }}" @else class="cover" @endif alt="{{ $name }}" />
    </span>
    <div>
      <p class="name-15 pj-bold">{{ $name }}</p>
      <p class="sub-12 in-reg">{{ $major }}</p>
    </div>
  </div>

  <p class="meta in-reg">
    <span>
      <img src="{{ asset('image/385bf.svg') }}" width="9.33333" height="11.6667" alt="" />
      {{ $city }}
    </span>
    <span>
      <img src="{{ asset('image/4e738.svg') }}" width="9.33333" height="9.33333" alt="" />
      {{ $gender }}
    </span>
  </p>

  <div class="friend-foot">
    <div class="tags in-semi">
      @foreach($tags as $index => $tag)
        <span class="tag {{ $index === 0 ? 'primary' : 'muted' }}">{{ $tag }}</span>
      @endforeach
    </div>
    <a class="chat-btn in-semi" href="{{ $chatUrl }}">
      <img src="{{ asset('image/f2761.svg') }}" width="13.3333" height="13.3333" alt="" />
      Chat
    </a>
  </div>
</article>
