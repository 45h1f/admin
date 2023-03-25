<?php

use App\Layout\Content;
use Ashiful\Extensions\PHPInfo\Services\PHPInfo;
use Illuminate\Support\Facades\Route;


$path = PHPInfo::config('path', 'phpinfo');

Route::get($path, function (Content $content, PHPInfo $info) {
    $info = $info->toCollection();

    return $content
        ->header('PHP\'s configuration')
        ->description(' ')
        ->body(view('laravel-admin-phpinfo::phpinfo', compact('info')));
});
