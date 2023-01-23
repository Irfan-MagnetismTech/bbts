<?php

use App\Http\Controllers\Dataencoding\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Dataencoding\EmployeeController;
use App\Http\Controllers\Dataencoding\DepartmentController;
use App\Http\Controllers\Dataencoding\DesignationController;

Route::prefix('dataencoding')->as('dataencoding.')->group(function ()
{
    Route::resource('departments', DepartmentController::class);
    Route::resource('designations', DesignationController::class);
    Route::resource('employees', EmployeeController::class);
});
