<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\MyCompanyController;

// Shared Routes (admin + company-owner)
Route::middleware(['auth', 'role:admin,company-owner'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Job Applications
    Route::resource('applications', ApplicationController::class);
    Route::put('/applications/{id}/restore', [ApplicationController::class, 'restore'])->name('applications.restore');

    // Job Vacancies
    Route::resource('job-vacancies', JobVacancyController::class);
    Route::put('job-vacancies/{id}/restore', [JobVacancyController::class, 'restore'])->name('job-vacancies.restore');
});

// Company Owner Routes
Route::middleware(['auth', 'role:company-owner'])->group(function () {
    Route::get('/my-company', [CompanyController::class, 'show'])->name('my-company.show');
    Route::get('/my-company/edit', [CompanyController::class, 'edit'])->name('my-company.edit');
    Route::put('/my-company/update', [CompanyController::class, 'update'])->name('my-company.update');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Job Categories
    Route::resource('categories', CategoryController::class);
    Route::put('/categories/{id}/restore', [CategoryController::class, 'restore'])->name('categories.restore');

    // Users
    Route::resource('users', UserController::class);
    Route::put('/users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');

    // Companies
    Route::resource('companies', CompanyController::class);
    Route::put('/companies/{id}/restore', [CompanyController::class, 'restore'])->name('companies.restore');
});


require __DIR__.'/auth.php';