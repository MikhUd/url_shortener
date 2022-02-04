<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShortUrlController;

Route::get('/', function () {
    return view('url');
});

Route::post('/', [ShortUrlController::class, 'shortenUrl']);
Route::get('/{token}', [ShortUrlController::class, 'redirectToUrl']);