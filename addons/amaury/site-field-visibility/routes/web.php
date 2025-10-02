<?php

use Illuminate\Support\Facades\Route;
use Amaury\SiteFieldVisibility\Http\Controllers\SettingsController;

Route::middleware(['web', 'statamic.cp.authenticated'])->prefix('cp')->group(function () {
    Route::get('/field-visibility/settings', [SettingsController::class, 'index'])->name('field-visibility.settings');
    Route::post('/field-visibility/settings', [SettingsController::class, 'store'])->name('field-visibility.store');
    Route::get('/field-visibility/config/{siteHandle}', [SettingsController::class, 'config'])->name('field-visibility.config');
});
