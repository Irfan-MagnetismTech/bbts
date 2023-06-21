<?php


use Illuminate\Support\Facades\Route;
use Modules\Networking\Http\Controllers\NetPopEquipmentController;

Route::resources([
    'pop-equipments'          => NetPopEquipmentController::class,
]);
