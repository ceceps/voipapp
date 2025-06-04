<?php

use App\Http\Controllers\ContactController;

Route::middleware('guest')->group(function () {
    Route::get('/contacts', [ContactController::class, 'index']);
});
