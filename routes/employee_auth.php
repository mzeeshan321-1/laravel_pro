<?php

use App\Http\Controllers\employee\dashboardController;
use App\Http\Controllers\employee\LeavesController;
use App\Http\Controllers\employee\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'user_auth:employee', 'verified'])->prefix('employee')->group(function () {

    Route::get('/dashboard', [dashboardController::class, 'create'])->name('employee.dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('employee.profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('employee.profile.update');
    Route::post('/profile/account', [ProfileController::class, 'ChangePassword'])->name('employee.profile.ChangePassword');

    // Leave Routes
    Route::resource('leaves', LeavesController::class)
        ->except(['show'])
        ->names([
            'index' => 'employee.leaves',
            'create' => 'employee.leaves.create',
            'store' => 'employee.leaves.store',
            'edit' => 'employee.leaves.edit',
            'update' => 'employee.leaves.update',
            'destroy' => 'employee.leaves.destroy',
        ]);
});
