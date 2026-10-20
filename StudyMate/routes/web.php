<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;

// ── Public Routes ──────────────────────────────────────────
Route::get('/', function () {
    return view('index');
})->name('home');

// API Proxy Wilayah (Registrasi)
Route::get('/api/wilayah/provinces', [RegisterController::class, 'getProvinces']);
Route::get('/api/wilayah/regencies/{code}', [RegisterController::class, 'getRegencies']);


// ── Guest Only (Akses ditolak jika sudah login) ─────────────
Route::middleware('guest')->group(function () {
    // Auth Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    // Register Wizard
    Route::get('/register', function () {   
        return view('nama');
    })->name('register');
    Route::post('/register/nama', [RegisterController::class, 'namaStore'])->name('register.nama.store');

    Route::get('/prodi', function () {   
        return view('prodi');
    })->name('register.prodi');
    Route::post('/register/prodi', [RegisterController::class, 'prodiStore'])->name('register.prodi.store');

    Route::get('/minat', function () {   
        return view('minat');
    })->name('register.minat');
    Route::post('/register/minat', [RegisterController::class, 'minatStore'])->name('register.minat.store');

    Route::get('/domisili', function () {   
        return view('domisili');
    })->name('register.domisili');
    Route::post('/register/domisili', [RegisterController::class, 'domisiliStore'])->name('register.domisili.store');

    Route::get('/password', function () {   
        return view('password');
    })->name('register.password');
    Route::post('/register/store', [RegisterController::class, 'store'])->name('register.store');
});


// ── Authenticated Only (Wajib Login) ───────────────────────
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/dashboard', function () {   
        return view('dashboard');
    })->name('dashboard');

    Route::get('/chat', function () {
        return view('chat');
    })->name('chat');

    Route::get('/jadwal', function () {
        return view('jadwal');
    })->name('jadwal');

    Route::get('/validasi', function () {
        return view('validasifoto');
    })->name('validasi');

    Route::get('/profil', function () {
        return view('profil');
    })->name('profil');

    Route::get('/cari', function () {
        return view('cari');
    })->name('cari');

    Route::get('/hasil', function () {
        return view('hasil');
    })->name('hasil');

    Route::get('/chat-room', function () {
        return view('chat-room');
    })->name('chat-room');

    Route::get('/materi', function () {
        return view('materi');
    })->name('materi');

    Route::get('/kuis', function () {
        return view('kuis');
    })->name('kuis');
});
