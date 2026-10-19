<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/login', function () { 
    return view('login');
});

Route::post('/login', function () {
    return redirect('/dashboard');
});

Route::get('/register', function () {   
    return view('nama');
});

Route::get('/prodi', function () {   
    return view('prodi');
});

Route::get('/minat', function () {   
    return view('minat');
});

Route::get('/domisili', function () {   
    return view('domisili');
});

Route::get('/password', function () {   
    return view('password');
});

Route::get('/dashboard', function () {   
    return view('dashboard');
});

Route::get('/chat', function () {
    return view('chat');
});

Route::get('/jadwal', function () {
    return view('jadwal');
});

Route::get('/validasi', function () {
    return view('validasifoto');
});

Route::get('/profil', function() {
    return view('profil');
});

Route::get('/cari', function() {
    return view('cari');
});

Route::get('/hasil', function() {
    return view('hasil');
});

Route::get('/chat-room', function() {
    return view('chat-room');
});

Route::get('/materi', function() {
    return view('materi');
});

Route::get('/kuis', function() {
    return view('kuis');
});

