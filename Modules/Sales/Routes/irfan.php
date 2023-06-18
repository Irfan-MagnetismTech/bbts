<?php

use Illuminate\Support\Facades\Route;
use Modules\Sales\Http\Controllers\SaleController;

Route::resources([
    'sales' => SaleController::class,
]);
