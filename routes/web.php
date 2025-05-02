<?php

use Illuminate\Support\Facades\Route;


//Projects route page
Route::get('/projects', function () {
    return view('layouts.projects');
});

//Users route page
Route::get('/users', function () {
    return view('layouts.users');
});


//Login page
Route::get('/login', function () {
    return view('auth.login');
});

//Login request
Route::post('/login', function () {
    return view('home');
});

//Register page
Route::post('/register', function () {
    return view('auth.register');
});
Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('projects');
