<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//Start route page
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Home route page
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Projects route page
Route::get('/projects', [App\Http\Controllers\ProjectController::class, 'index'])->name('projects');
//Users route page
Route::get('/users', [App\Http\Controllers\HomeController::class, 'index'])->name('users');

//Projects page
Route::get('/projects', function () {
    // Check if the user is authenticated
    if (!Auth::check()) return redirect('login');

    return view('projects');
});

//Users page
Route::get('/users', function () {
    // Check if the user is authenticated 
    if (!Auth::check()) return redirect('login');

    return view('users');
});


Route::post('/projects', [App\Http\Controllers\ProjectController::class, 'projects'])->name('projects');

Auth::routes();
