<?php


use Ashiful\Extensions\GridSortable\Controllers\GridSortableController;
use Illuminate\Support\Facades\Route;

Route::post('_grid-sortable_', [GridSortableController::class, 'sort'])->name('laravel-admin-grid-sortable');
