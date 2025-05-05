<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//Start route page
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home')->middleware('auth');

//Home route page
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home')->middleware('auth');
//Projects route page
Route::get('/projects', [App\Http\Controllers\ProjectController::class, 'index'])
    ->name('projects')->middleware('auth');
//Users route page
Route::get('/users', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('users')->middleware('auth');

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



Auth::routes();
