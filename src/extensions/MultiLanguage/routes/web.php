<?php


use Ashiful\Extensions\MultiLanguage\Controllers\MultiLanguageController;
use Ashiful\Extensions\MultiLanguage\Services\MultiLanguage;
use Illuminate\Support\Facades\Route;

Route::post('/locale', MultiLanguageController::class . '@locale');
if (MultiLanguage::config("show-login-page", true)) {
    Route::get('auth/login', MultiLanguageController::class . '@getLogin');
}
