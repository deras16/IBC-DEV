<?php

use App\Http\Controllers\CaseStudy\CaseStudyController;
use App\Http\Controllers\CaseStudy\Marketing\MarketingCaseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\RoleController;
use App\Http\Controllers\User\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth', 'checkUserHasRole'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('case-studies', CaseStudyController::class);
    Route::post('case-studies/{case_study}/load-twitter-data',[CaseStudyController::class, 'loadTwitterData'])->name('case-studies.loadTwitterData');
    Route::resource('marketing-case-studies', MarketingCaseController::class);
    Route::get('marketing-case-studies/{marketing_case_study}/file', [MarketingCaseController::class, 'createFile'])->name('marketing-case-studies.createFile');
    Route::get('marketing-case-studies/{marketing_case_study}/file/{file}/download', [MarketingCaseController::class, 'downloadFile'])->name('marketing-case-studies.downloadFile');
    Route::post('marketing-case-studies/{marketing_case_study}/load-twitter-data',[MarketingCaseController::class, 'loadTwitterData'])->name('marketing-case-studies.loadTwitterData');
    Route::post('marketing-case-studies/{marketing_case_study}/file', [MarketingCaseController::class, 'storeFile'])->name('marketing-case-studies.storeFile');
    Route::delete('marketing-case-studies/{marketing_case_study}/file/{file}', [MarketingCaseController::class, 'destroyFile'])->name('marketing-case-studies.destroyFile');

    Route::resource('users', UserController::class);
    Route::post('users/{user}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::resource('roles', RoleController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
