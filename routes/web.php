<?php

use App\Http\Controllers\EstimatePdfController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Building a PDF takes real CPU time, so each visitor gets a handful per minute.
Route::post('/estimate.pdf', EstimatePdfController::class)
    ->middleware('throttle:10,1')
    ->name('estimate.pdf');
