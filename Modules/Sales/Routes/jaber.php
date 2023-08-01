<?php

use Illuminate\Support\Facades\Route;
use Modules\Sales\Http\Controllers\OfferController;

Route::resources([
    'offers' => OfferController::class,
]);
