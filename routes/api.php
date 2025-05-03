<?php
use Illuminate\Http\Request;
use App\Http\Controllers\EventController;

Route::resource('events', EventController::class);