<?php

use App\Http\Controllers\Admin\dashboardController;
use App\Http\Controllers\Admin\HrController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'user_auth:admin', 'verified'])->prefix('admin')->group(function () {

    Route::get('/dashboard',[dashboardController::class, 'create'])->name('admin.dashboard');
    
    // HR Routes
    Route::resource('hr', HrController::class)
        ->except(['show'])
        ->names([
            'index' => 'admin.hr',
            'create' => 'admin.hr.create',
            'store' => 'admin.hr.store',
            'edit' => 'admin.hr.edit',
            'update' => 'admin.hr.update',
            'destroy' => 'admin.hr.destroy',
        ]);
    
    //     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    //     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    //     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
