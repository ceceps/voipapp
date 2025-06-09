<?php

use App\Http\Controllers\CallController;
use App\Http\Controllers\ContactController;

Route::get('/contacts', [ContactController::class, 'index']);
Route::post('/simulate-call/{contact}', [CallController::class, 'calls']);
Route::get('/call-logs', action: [CallController::class, 'logs']);
Route::post('/favorite', action: [ContactController::class, 'favorite']);
