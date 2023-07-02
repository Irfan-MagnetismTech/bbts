<?php


use Illuminate\Support\Facades\Route;
use Modules\Networking\Http\Controllers\PhysicalConnectivityController;

Route::resources([
    'physical-connectivities' => PhysicalConnectivityController::class,
]);
