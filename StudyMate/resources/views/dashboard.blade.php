@extends('layouts.app')

@section('title', 'Dashboard')
@section('meta-description', 'Dashboard StudyMate - Temukan teman belajar, pantau peringkat streak, dan rekomendasi studi terkini.')

@section('content')
  <div class="greet">
    <h1 class="pj-xbold">Halo, Komang.</h1>
    <a class="find-btn pj-semi" href="/cari">
      <img src="{{ asset('image/78380.svg') }}" width="13.5" height="13.5" alt="" />Cari Teman Belajar
    </a>
  </div>

  {{-- Section Rekomendasi Teman Belajar --}}
  <section aria-labelledby="rek">
    <div class="sec-head">
      <h2 id="rek" class="pj-bold">Rekomendasi Teman Belajar</h2>
      <a class="pj-semi" href="/cari">Lihat semua</a>
    </div>

    <div class="rail">
      <x-friend-card
        name="Utami Putri"
        major="Informatika"
        city="Surabaya"
        gender="Perempuan"
        photo="/image/935bb.png"
        :tags="['Database', 'SQL']"
        chatUrl="/chat-room?nama=Utami%20Putri"
      />

      <x-friend-card
        name="Kadek Kiko"
        major="Informatika"
        city="Surabaya"
        gender="Laki-laki"
        photo="/image/8fb29.png"
        :tags="['Database', 'UI/UX']"
        chatUrl="/chat-room?nama=Kadek%20Kiko"
      />

      <x-friend-card
        name="Fairruzahwa Lestari"
        major="Informatika"
        city="Sidoarjo"
        gender="Perempuan"
        photo="/image/d77e9.png"
        photoStyle="left:0;top:-58.02%;width:100%;height:216.03%"
        :tags="['Machine Learning', 'Python']"
        chatUrl="/chat-room?nama=Fairruzahwa%20Lestari"
      />
    </div>
  </section>

  {{-- Grid: Ranking Bulanan & Streak --}}
  <div class="grid">
    <section class="card rank" aria-labelledby="rank">
      <div class="rank-head">
        <h2 id="rank" class="pj-xbold">
          <img src="{{ asset('image/27e26.svg') }}" width="9.16667" height="18.3333" alt="" />Ranking Bulanan
        </h2>
        <span class="badge in-semi">Top 5</span>
      </div>
      <ol class="rank-list">
        <li class="row top">
          <div class="row-l">
            <img src="{{ asset('image/56457.svg') }}" width="13.3333" height="17.5" alt="Peringkat 1" />
            <span class="av av-36"><span class="clip"><img src="{{ asset('image/682cd.png') }}" style="position:absolute;max-width:none;left:-20.37%;top:-17.2%;width:118.69%;height:212.47%" alt="" /></span></span>
            <div><p class="name-13 pj-bold">Anasthasya P</p><p class="sub-11 in-reg">Kedokteran Gigi</p></div>
          </div>
          <p class="score"><b class="pj-xbold">10.555</b><small class="pj-bold">Streak</small></p>
        </li>
        <li class="row">
          <div class="row-l">
            <span class="pos in-semi">#2</span>
            <span class="av av-32"><img src="{{ asset('image/4293c.png') }}" style="left:0.3%;top:-0.95%;width:120.73%;height:117.5%" alt="" /></span>
            <div><p class="name-13 pj-bold">Difa Andini</p><p class="sub-11 in-reg">Kedokteran Hewan</p></div>
          </div>
          <p class="score"><b class="pj-bold">2.180</b><small class="pj-semi">Streak</small></p>
        </li>
        <li class="row">
          <div class="row-l">
            <span class="pos in-semi">#3</span>
            <span class="av av-32"><img src="{{ asset('image/adbbd.png') }}" style="left:0;top:0;width:100%;height:100%" alt="" /></span>
            <div><p class="name-13 pj-bold">Firda Utami</p><p class="sub-11 in-reg">Manajemen</p></div>
          </div>
          <p class="score"><b class="pj-bold">1.930</b><small class="pj-semi">Streak</small></p>
        </li>
        <li class="row">
          <div class="row-l">
            <span class="pos in-semi">#4</span>
            <span class="av av-32"><img src="{{ asset('image/1f2e8.png') }}" style="left:-1.03%;top:-12.04%;width:100%;height:148.91%" alt="" /></span>
            <div><p class="name-13 pj-bold">Fairuzzahwa</p><p class="sub-11 in-reg">Statistika</p></div>
          </div>
          <p class="score"><b class="pj-bold">1.820</b><small class="pj-semi">Streak</small></p>
        </li>
        <li class="row">
          <div class="row-l">
            <span class="pos in-semi">#5</span>
            <span class="av av-32"><img src="{{ asset('image/16a56.png') }}" style="left:0.85%;top:-23.74%;width:100%;height:133.33%" alt="" /></span>
            <div><p class="name-13 pj-bold">Kadek Kiko</p><p class="sub-11 in-reg">Perhotelan</p></div>
          </div>
          <p class="score"><b class="pj-bold">1.750</b><small class="pj-semi">Streak</small></p>
        </li>
      </ol>
    </section>

    <section class="card streak" aria-labelledby="streak">
      <div>
        <h2 id="streak" class="pj-bold">Streak Belajar Bulan Ini</h2>
        <p class="sub-12 in-reg" style="margin-top:2px">3 streak terpenuhi!</p>
      </div>
      <ol class="weeks">
        <li class="pj-semi">Week 1 <span class="wk done"><img src="{{ asset('image/e0f80.svg') }}" width="12.225" height="9.01875" alt="Selesai" /></span></li>
        <li class="pj-semi">Week 2 <span class="wk done"><img src="{{ asset('image/e0f80.svg') }}" width="12.225" height="9.01875" alt="Selesai" /></span></li>
        <li class="pj-semi">Week 3 <span class="wk done"><img src="{{ asset('image/e0f80.svg') }}" width="12.225" height="9.01875" alt="Selesai" /></span></li>
        <li class="pj-semi">Week 4 <span class="wk"><i></i></span></li>
      </ol>
    </section>
  </div>
@endsection
