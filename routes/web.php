<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//Home route page
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Projects route page
Route::get('/projects', [App\Http\Controllers\HomeController::class, 'index'])->name('projects');
//Users route page
Route::get('/users', [App\Http\Controllers\HomeController::class, 'index'])->name('users');

//Projects page
Route::get('/projects', function () {
    if (!Auth::check()) {
        return redirect('login');
    }
    return view('layouts.projects');
});

//Users page
Route::get('/users', function () {
    if (!Auth::check()) {
        return redirect('login');
    }
    return view('layouts.users');
});

Auth::routes();
