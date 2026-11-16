<?php

use App\Http\Controllers\AccountSessionController;
use App\Http\Controllers\PublicDirectoryController;
use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'application' => 'estudent-institutes-v2',
        'foundation' => 'fnd-01',
    ]);
})->name('health');

Route::post('/account/session', [AccountSessionController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('account.session.store');

Route::delete('/account/session', [AccountSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('account.session.destroy');

Route::get('/directory', [PublicDirectoryController::class, 'index'])
    ->middleware('throttle:60,1')
    ->name('directory.index');

Route::get('/directory/{entity}', [PublicDirectoryController::class, 'show'])
    ->whereUuid('entity')
    ->middleware('throttle:60,1')
    ->name('directory.show');
