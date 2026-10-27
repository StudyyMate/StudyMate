<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;

// API Proxy Wilayah (Registrasi & Profil)
Route::get('/api/wilayah/provinces', [RegisterController::class, 'getProvinces']);
Route::get('/api/wilayah/regencies/{code?}', [RegisterController::class, 'getRegencies']);

// Guest Only Akses ditolak jika sudah login (Landing Page, Login, Register)
Route::middleware('guest')->group(function () {
    // Halaman awal / Landing Page
    Route::get('/', function () {
        return view('index');
    })->name('home');

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
    Route::post('/register/store', [RegisterController::class, 'store'])->name('register.store');
});


// Authenticated Only (Wajib Login) 
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

    Route::get('/profil', [ProfileController::class, 'show'])->name('profil');
    Route::post('/profil', [ProfileController::class, 'update'])->name('profil.update');

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
