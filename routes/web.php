<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();



Route::group(['middleware' => ['auth']], function () {

    //Start page
    Route::get('/', function () {
        // Check if the user is authenticated
        if (!Auth::check()) return redirect('login');

        return view('home');
    });

    //Home page
    Route::get('/home', function () {
        // Check if the user is authenticated
        if (!Auth::check()) return redirect('login');

        return view('home');
    });


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
});
