<?php

use App\Http\Controllers\AccountSessionController;
use App\Http\Controllers\PublicDirectoryController;
use App\Http\Controllers\UniversityRepresentativeWorkflowController;
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

Route::middleware('auth')->prefix('/institutions/{institution}')->whereUuid('institution')->group(function (): void {
    Route::post('/claims', [UniversityRepresentativeWorkflowController::class, 'store'])
        ->middleware('throttle:20,1')
        ->name('institutions.claims.store');

    Route::post('/claims/{claimVersion}/correction', [UniversityRepresentativeWorkflowController::class, 'correct'])
        ->whereUuid('claimVersion')
        ->middleware('throttle:20,1')
        ->name('institutions.claims.correct');

    Route::post('/editorial-cases/{case}/review', [UniversityRepresentativeWorkflowController::class, 'startReview'])
        ->whereUuid('case')
        ->middleware('throttle:30,1')
        ->name('institutions.editorial-cases.review.start');

    Route::patch('/editorial-cases/{case}/review', [UniversityRepresentativeWorkflowController::class, 'completeReview'])
        ->whereUuid('case')
        ->middleware('throttle:30,1')
        ->name('institutions.editorial-cases.review.complete');
});

Route::get('/directory', [PublicDirectoryController::class, 'index'])
    ->middleware('throttle:60,1')
    ->name('directory.index');

Route::get('/directory/{entity}', [PublicDirectoryController::class, 'show'])
    ->whereUuid('entity')
    ->middleware('throttle:60,1')
    ->name('directory.show');
