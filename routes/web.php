<?php

use App\Http\Controllers\CaseStudy\CaseStudyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('case-studies', CaseStudyController::class);
    Route::get('case-studies/{caseStudy}/file', [CaseStudyController::class, 'createFile'])->name('case-studies.createFile');
    Route::get('case-studies/{caseStudy}/file/{file}/download', [CaseStudyController::class, 'downloadFile'])->name('case-studies.downloadFile');
    Route::post('case-studies/{caseStudy}/file', [CaseStudyController::class, 'storeFile'])->name('case-studies.storeFile');
    Route::delete('case-studies/{caseStudy}/file/{file}', [CaseStudyController::class, 'destroyFile'])->name('case-studies.destroyFile');

    Route::resource('users', UserController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
