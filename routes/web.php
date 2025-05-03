<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConfigController;

Route::middleware(['tenant'])->group(function () {
    Route::get('/', fn () => view('welcome'));
    Route::get('/config/{tenant_id}', [ConfigController::class, 'show']);
    Route::get('/{tenant_id}/page', [ConfigController::class, 'showPage']);
});
