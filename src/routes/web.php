<?php

use Illuminate\Support\Facades\Route;
use admin\banners\Controllers\BannerManagerController;

Route::name('admin.')->middleware(['web','auth:admin'])->group(function () {  
    Route::middleware('auth:admin')->group(function () {
        Route::resource('banners', BannerManagerController::class);
    });
});
