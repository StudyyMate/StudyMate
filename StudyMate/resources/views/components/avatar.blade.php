{{--
  components/avatar.blade.php
  ===========================
  Komponen avatar profil serbaguna.
  Props:
    - $src    : Path gambar avatar
    - $alt    : Teks alt gambar
    - $size   : Ukuran (44, 36, 32, dsb)
    - $online : Boolean status online
    - $class  : Class tambahan
    - $style  : Inline style gambar jika ada
--}}
@props([
  'src' => '/image/935bb.png',
  'alt' => '',
  'size' => 44,
  'online' => false,
  'class' => '',
  'style' => null
])

<span class="av av-{{ $size }} {{ $class }}">
  <img src="{{ asset($src) }}" @if($style) style="{{ $style }}" @else class="cover" @endif alt="{{ $alt }}" />
  @if($online)
    <span class="online-dot" aria-label="Online"></span>
  @endif
</span>
