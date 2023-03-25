<?php


use Ashiful\Extensions\EnvManager\Controllers\EnvManagerController;
use Illuminate\Support\Facades\Route;

Route::resource('env-manager', EnvManagerController::class);
