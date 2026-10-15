<?php

namespace App\Http\Controllers;

use App\Support\Content;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * The one-page site in Georgian at "/", or in another language at "/ru" and "/en".
     */
    public function index(?string $locale = null): View
    {
        $locale ??= Content::defaultLocale();
        app()->setLocale($locale);

        return view('home', [
            'content' => Content::get($locale),
        ]);
    }
}
