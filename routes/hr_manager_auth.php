<?php

use App\Http\Controllers\hr_manager\dashboardController;
use App\Http\Controllers\hr_manager\DepartmentsController;
use App\Http\Controllers\hr_manager\EmployeesController;
use App\Http\Controllers\hr_manager\HolidaysController;
use App\Http\Controllers\hr_manager\JobGradesController;
use App\Http\Controllers\hr_manager\JobHistoryController;
use App\Http\Controllers\hr_manager\JobPositionsController;
use App\Http\Controllers\hr_manager\LeavesController;
use App\Http\Controllers\hr_manager\ProfileController;
use App\Http\Controllers\hr_manager\PayrollController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'user_auth:hr_manager', 'verified'])->prefix('hr_manager')->group(function () {

    Route::get('/dashboard', [dashboardController::class, 'create'])->name('hr_manager.dashboard');
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('hr_manager.profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('hr_manager.profile.update');
    Route::post('/profile/account', [ProfileController::class, 'ChangePassword'])->name('hr_manager.profile.ChangePassword');
    // Employee Routes
    Route::get('/employees/{id}/e-profile', [EmployeesController::class, 'ShowEmployeeProfile'])->name('hr_manager.employees.e-profile');
    // Route::get('/employees', [EmployeesController::class, 'index'])->name('hr_manager.employees');
    // Route::get('/employees/create', [EmployeesController::class, 'create'])->name('hr_manager.employees.create');
    // Route::post('/employees', [EmployeesController::class, 'store'])->name('hr_manager.employees.store');
    // Route::get('/employees/{id}/edit', [EmployeesController::class, 'edit'])->name('hr_manager.employees.edit');
    // Route::put('/employees/{id}', [EmployeesController::class, 'update'])->name('hr_manager.employees.update');
    // Route::delete('/employees/{id}', [EmployeesController::class, 'delete'])->name('hr_manager.employees.delete');
    Route::resource('employees', EmployeesController::class)
        ->except(['show'])
        ->names([
            'index' => 'hr_manager.employees',
            'create' => 'hr_manager.employees.create',
            'store' => 'hr_manager.employees.store',
            'edit' => 'hr_manager.employees.edit',
            'update' => 'hr_manager.employees.update',
            'destroy' => 'hr_manager.employees.destroy',
        ]);

    // Department Routes
    Route::resource('departments', DepartmentsController::class)
        ->except(['show'])
        ->names([
            'index' => 'hr_manager.departments',
            'create' => 'hr_manager.departments.create',
            'store' => 'hr_manager.departments.store',
            'edit' => 'hr_manager.departments.edit',
            'update' => 'hr_manager.departments.update',
            'destroy' => 'hr_manager.departments.destroy',
        ]);

    // Holiday Routes
    Route::resource('holidays', HolidaysController::class)
        ->except(['show'])
        ->names([
            'index' => 'hr_manager.holidays',
            'create' => 'hr_manager.holidays.create',
            'store' => 'hr_manager.holidays.store',
            'edit' => 'hr_manager.holidays.edit',
            'update' => 'hr_manager.holidays.update',
            'destroy' => 'hr_manager.holidays.destroy',
        ]);

    // Leave Routes
    Route::get('/leave-requests', [LeavesController::class, 'leaveRequests'])->name('hr_manager.leaves.leaveRequests');
    Route::get('/leave-requests/{id}/approve', [LeavesController::class, 'approveLeave'])->name('hr_manager.leaves.approveLeave');
    Route::get('/leave-requests/{id}/reject', [LeavesController::class, 'rejectLeave'])->name('hr_manager.leaves.rejectLeave');
    Route::resource('leaves', LeavesController::class)
        ->except(['show'])
        ->names([
            'index' => 'hr_manager.leaves',
            'create' => 'hr_manager.leaves.create',
            'store' => 'hr_manager.leaves.store',
            'edit' => 'hr_manager.leaves.edit',
            'update' => 'hr_manager.leaves.update',
            'destroy' => 'hr_manager.leaves.destroy',
        ]);

    // Jobs Routes
    Route::resource('jobs', JobPositionsController::class)
        ->except(['show'])
        ->names([
            'index' => 'hr_manager.jobs',
            'create' => 'hr_manager.jobs.create',
            'store' => 'hr_manager.jobs.store',
            'edit' => 'hr_manager.jobs.edit',
            'update' => 'hr_manager.jobs.update',
            'destroy' => 'hr_manager.jobs.destroy',
        ]);

    // Job History Routes
    Route::resource('job_history', JobHistoryController::class)
        ->except(['show'])
        ->names([
            'index' => 'hr_manager.job_history',
            'create' => 'hr_manager.job_history.create',
            'store' => 'hr_manager.job_history.store',
            'edit' => 'hr_manager.job_history.edit',
            'update' => 'hr_manager.job_history.update',
            'destroy' => 'hr_manager.job_history.destroy',
        ]);

    // Job Grades Routes
    Route::resource('job_grades', JobGradesController::class)
        ->except(['show'])
        ->names([
            'index' => 'hr_manager.job_grades',
            'create' => 'hr_manager.job_grades.create',
            'store' => 'hr_manager.job_grades.store',
            'edit' => 'hr_manager.job_grades.edit',
            'update' => 'hr_manager.job_grades.update',
            'destroy' => 'hr_manager.job_grades.destroy',
        ]);

    // Payroll Routes
    Route::resource('payroll', PayrollController::class)
        ->except(['show'])
        ->names([
            'index' => 'hr_manager.payroll',
            'create' => 'hr_manager.payroll.create',
            'store' => 'hr_manager.payroll.store',
            'edit' => 'hr_manager.payroll.edit',
            'update' => 'hr_manager.payroll.update',
            'destroy' => 'hr_manager.payroll.destroy',
        ]);
});
