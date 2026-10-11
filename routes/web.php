<?php

use App\Http\Controllers\EstimatePdfController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SeoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/robots.txt', [SeoController::class, 'robots']);
Route::get('/sitemap.xml', [SeoController::class, 'sitemap']);
Route::get('/llms.txt', [SeoController::class, 'llms']);

// Building a PDF takes real CPU time, so each visitor gets a handful per minute.
Route::post('/estimate.pdf', EstimatePdfController::class)
    ->middleware('throttle:10,1')
    ->name('estimate.pdf');
