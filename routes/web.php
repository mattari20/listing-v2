<?php

use App\Http\Controllers\AccountSavedItemsController;
use App\Http\Controllers\AccountSessionController;
use App\Http\Controllers\AdministrationWorkspaceController;
use App\Http\Controllers\EditorialCaseWorkspaceController;
use App\Http\Controllers\InstitutionCampusWorkflowController;
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

Route::get('/workspace', [AdministrationWorkspaceController::class, 'index'])
    ->middleware(['auth', 'throttle:30,1'])
    ->name('workspace.index');

Route::get('/institutions/{institution}/editorial-cases/{case}', [EditorialCaseWorkspaceController::class, 'show'])
    ->middleware(['auth', 'throttle:30,1'])
    ->whereUuid('institution')
    ->whereUuid('case')
    ->name('institutions.editorial-cases.show');

Route::middleware(['auth', 'throttle:60,1'])->prefix('/account/saved-items')->name('account.saved-items.')->group(function (): void {
    Route::get('/', [AccountSavedItemsController::class, 'index'])->name('index');
    Route::post('/{entity}', [AccountSavedItemsController::class, 'store'])->whereUuid('entity')->middleware('throttle:20,1')->name('store');
    Route::delete('/{entity}', [AccountSavedItemsController::class, 'destroy'])->whereUuid('entity')->middleware('throttle:30,1')->name('destroy');
});

Route::middleware('auth')->prefix('/institutions/{institution}')->group(function (): void {
    Route::post('/claims', [UniversityRepresentativeWorkflowController::class, 'store'])
        ->middleware('throttle:20,1')
        ->whereUuid('institution')
        ->name('institutions.claims.store');

    Route::post('/claims/{claimVersion}/correction', [UniversityRepresentativeWorkflowController::class, 'correct'])
        ->whereUuid('claimVersion')
        ->middleware('throttle:20,1')
        ->whereUuid('institution')
        ->name('institutions.claims.correct');

    Route::post('/editorial-cases/{case}/review', [UniversityRepresentativeWorkflowController::class, 'startReview'])
        ->whereUuid('case')
        ->middleware('throttle:30,1')
        ->whereUuid('institution')
        ->name('institutions.editorial-cases.review.start');

    Route::patch('/editorial-cases/{case}/review', [UniversityRepresentativeWorkflowController::class, 'completeReview'])
        ->whereUuid('case')
        ->middleware('throttle:30,1')
        ->whereUuid('institution')
        ->name('institutions.editorial-cases.review.complete');
});

Route::middleware(['auth', 'throttle:30,1'])->prefix('/institutions/{institution}')->group(function (): void {
    Route::get('/information', [InstitutionCampusWorkflowController::class, 'information'])
        ->whereUuid('institution')
        ->name('institutions.information');
    Route::post('/campuses', [InstitutionCampusWorkflowController::class, 'storeCampus'])
        ->middleware('throttle:20,1')
        ->whereUuid('institution')
        ->name('institutions.campuses.store');
    Route::post('/delivery-sites', [InstitutionCampusWorkflowController::class, 'storeDeliverySite'])
        ->middleware('throttle:20,1')
        ->whereUuid('institution')
        ->name('institutions.delivery-sites.store');
});

Route::get('/directory/compare', [PublicDirectoryController::class, 'compare'])
    ->middleware('throttle:30,1')
    ->name('directory.compare');

Route::post('/directory/{entity}/shortlist', [PublicDirectoryController::class, 'addToShortlist'])
    ->whereUuid('entity')
    ->middleware('throttle:30,1')
    ->name('directory.shortlist.add');

Route::delete('/directory/shortlist/{entity}', [PublicDirectoryController::class, 'removeFromShortlist'])
    ->whereUuid('entity')
    ->middleware('throttle:30,1')
    ->name('directory.shortlist.remove');

Route::get('/directory', [PublicDirectoryController::class, 'index'])
    ->middleware('throttle:60,1')
    ->name('directory.index');

Route::get('/directory/{entity}', [PublicDirectoryController::class, 'show'])
    ->whereUuid('entity')
    ->middleware('throttle:60,1')
    ->name('directory.show');
