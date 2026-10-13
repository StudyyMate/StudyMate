<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/login', function () { 
    return view('login');
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

Route::get('/profil', function() {
    return view('profil');
});