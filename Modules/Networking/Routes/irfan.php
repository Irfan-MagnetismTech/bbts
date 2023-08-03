<?php


use Illuminate\Support\Facades\Route;
use Modules\Networking\Http\Controllers\NetPopEquipmentController;
use Modules\Networking\Http\Controllers\NetFiberManagementController;
use Modules\Networking\Http\Controllers\NetServiceRequisitionController;

Route::resources([
    'pop-equipments'            => NetPopEquipmentController::class,
    'service-requisitions'      => NetServiceRequisitionController::class,
    'fiber-managements'         => NetFiberManagementController::class,
]);
