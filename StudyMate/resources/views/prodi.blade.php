@extends('layouts.register')

@section('title', 'Daftar - Program Studi')
@section('progress', '40%')
@section('back-url', '/register')
@section('page-style', '--grad-top: #cde6ff')
@section('track-style', '--track: #ffffff')

@section('content')
  <div class="reg-step is-split">
    <div class="reg-step-group">
      <span class="f-semibold" style="color:#3525cd;letter-spacing:1.1px">LANGKAH 02</span>
      <span class="f-medium" style="color:#c7c4d8;letter-spacing:0.66px">/</span>
      <span class="f-medium" style="color:#464555;letter-spacing:0.55px">05 AKADEMIK</span>
    </div>
    <span class="f-medium" style="color:rgba(70,69,85,0.8);letter-spacing:0.66px">Estimasi 1 mnt</span>
  </div>
  <h1 class="reg-title">Pilih program studi Anda</h1>
  <p class="reg-lead">Membantu untuk menemukan teman yang relevan dengan program studi anda.</p>

  <form class="reg-form" action="/minat" method="get">
    <div class="field" style="gap:4px">
      <label class="label f-medium" for="prodi">Program Studi</label>
      <div class="input-wrap">
        <span class="input-icon"><img src="{{ asset('image/94b7e.svg') }}" width="15" height="15" alt="" /></span>
        <input class="input has-icon is-search" id="prodi" name="prodi" type="search" placeholder="Cari atau ketik program studi" required />
      </div>
    </div>

    <fieldset class="chip-group">
      <legend class="f-semibold">Jurusan</legend>
      <div class="chips f-medium">
        <label class="chip"><input type="radio" name="jurusan" value="teknik" checked /><span>Teknik &amp; Informatika</span></label>
        <label class="chip"><input type="radio" name="jurusan" value="ekonomi" /><span>Ekonomi &amp; Bisnis</span></label>
        <label class="chip"><input type="radio" name="jurusan" value="desain" /><span>Desain &amp; Media</span></label>
        <label class="chip"><input type="radio" name="jurusan" value="sains" /><span>Sains &amp; Kedokteran</span></label>
      </div>
    </fieldset>

    <button class="cta" type="submit" style="margin-top:72px">
      Lanjut <img src="{{ asset('image/03d99.svg') }}" width="12" height="12" alt="" />
    </button>
  </form>
@endsection
