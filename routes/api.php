<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;

Route::group(['middleware' => ['api']], function () {
    Route::resource('events', EventController::class);
    Route::resource('users', UserController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('reports', ReportController::class);
});
