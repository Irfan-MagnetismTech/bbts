<?php

namespace App\Http\hidden;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;


Route::get('/down', function () {
    Artisan::call('down');

    return 'Application is now in maintenance mode.';
});
Route::get('/up', function () {
    Artisan::call('up');

    return 'Application is UP.';
});

Route::get('/optimize', function () {
    Artisan::call('optimize:clear');

    return 'Application is optimized.';
});
