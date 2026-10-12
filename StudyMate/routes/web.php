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
