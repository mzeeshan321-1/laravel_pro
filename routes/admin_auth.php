<?php

use App\Http\Controllers\Admin\dashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'user_auth:admin', 'verified'])->prefix('admin')->group(function () {

    Route::get('/dashboard',[dashboardController::class, 'create'])->name('admin.dashboard');
    
    //     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    //     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    //     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
