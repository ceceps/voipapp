<?php

use App\Http\Controllers\CallController;
use App\Http\Controllers\ContactController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('guest')->group(function () {
    Route::get('/contacts', [ContactController::class, 'index']);
    // Route::post('/simulate-call/{contact}', [CallController::class, 'simulate']);
    // Route::get('/call-logs', [CallController::class, 'logs']);
});
