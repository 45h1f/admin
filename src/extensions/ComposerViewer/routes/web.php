<?php


use Ashiful\Extensions\ComposerViewer\Controllers\ComposerViewerController;
use Illuminate\Support\Facades\Route;

Route::get('composer-viewer', ComposerViewerController::class.'@index');
