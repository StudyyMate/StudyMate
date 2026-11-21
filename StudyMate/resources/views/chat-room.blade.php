@extends('layouts.app')

@section('title', 'Ruang Chat')
@section('page-class', 'room')
@section('main-class', 'room-main')

@section('content')
  <section class="conv-head">
    <a class="back" href="{{ route('chat') }}" aria-label="Kembali">
      <img src="{{ asset('image/e4c7b.svg') }}" width="18" height="18" alt="" />
    </a>
    <span class="ph">
      <span class="img">
        <img class="cover" src="{{ $partner->foto_profil ? asset('storage/'.$partner->foto_profil) : asset('image/avatar-default.svg') }}" alt="" />
      </span>
      <span class="online" aria-label="Online"></span>
    </span>
    <div class="p-info">
      <h1 class="p-name pj-bold" id="pName">{{ $partner->nama }}</h1>
      <p class="p-major pj-semi">{{ $partner->prodi }}</p>
      <p class="p-meta pj-med" id="pMeta">{{ $partner->lokasi['kota'] ?? '-' }} &middot; {{ $partner->gender }}</p>
    </div>
  </section>

  <section class="conv pj-med" id="conv" aria-live="polite">
    <span class="date-chip pj-semi">Percakapan</span>
    <p class="conv-empty">Memuat pesan...</p>
  </section>

  <form class="composer" id="composer" action="{{ route('chat.messages.send', $partner) }}" method="POST">
    @csrf
    <div class="field">
      <input type="text" id="msgInput" name="pesan" placeholder="Ketik pesan..." autocomplete="off" aria-label="Ketik pesan" />
    </div>
    <button class="send" type="submit" aria-label="Kirim">
      <img src="{{ asset('image/343eb.svg') }}" width="19" height="19" alt="" />
    </button>
  </form>
  <p id="chatError" role="alert" hidden style="color:#b91c1c;font-size:12px;padding:4px 0"></p>
@endsection

@push('scripts')
  <script>
    var getMessagesUrl = @json(route('chat.messages', $partner));
    var sendMessageUrl = @json(route('chat.messages.send', $partner));
    var csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    var conv = document.getElementById('conv');
    var input = document.getElementById('msgInput');
    var lastSignature = '';
    document.getElementById('pName').textContent = @json($partner->nama);
    document.querySelector('.p-major').textContent = @json($partner->prodi);
    document.getElementById('pMeta').textContent = @json(($partner->lokasi['kota'] ?? '-') . ' · ' . $partner->gender);

    async function loadMessages() {
      var response = await fetch(getMessagesUrl, { headers: { 'Accept': 'application/json' } });
      var data = await response.json();
      var signature = data.messages.map(function (message) { return message.id; }).join(',');
      if (signature === lastSignature) return;
      lastSignature = signature;
      conv.innerHTML = '<span class="date-chip pj-semi">Percakapan</span>';
      data.messages.forEach(function (message) {
        var element = document.createElement('div');
        element.className = 'msg' + (message.outgoing ? ' out' : '');
        element.textContent = message.message;
        var meta = document.createElement('span');
        meta.className = 'meta';
        meta.textContent = message.time || '';
        element.appendChild(meta);
        conv.appendChild(element);
      });
      if (!data.messages.length) conv.insertAdjacentHTML('beforeend', '<p class="conv-empty">Mulai percakapan untuk belajar bareng.</p>');
      conv.scrollTop = conv.scrollHeight;
    }

    document.getElementById('composer').addEventListener('submit', async function (event) {
      event.preventDefault();
      var pesan = input.value.trim();
      if (!pesan) return;
      input.disabled = true;
      try {
        var response = await fetch(sendMessageUrl, { method: 'POST', headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }, body: JSON.stringify({ pesan: pesan }) });
        if (!response.ok) throw new Error('HTTP ' + response.status);
        input.value = '';
        await loadMessages();
      } catch (error) {
        var errorBox = document.getElementById('chatError');
        errorBox.textContent = 'Pesan gagal dikirim. Coba lagi.';
        errorBox.hidden = false;
      } finally { input.disabled = false; input.focus(); }
    });
    loadMessages();
    setInterval(loadMessages, 2000);


  </script>
@endpush
