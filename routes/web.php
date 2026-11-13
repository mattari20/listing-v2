<?php

use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'application' => 'estudent-institutes-v2',
        'foundation' => 'fnd-01',
    ]);
})->name('health');
