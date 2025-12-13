<?php

use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\RoleController;
use App\Http\Controllers\User\PermissionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('users')->name('users.')->group(function () {
    
    Route::middleware('role:admin|super-admin')->prefix('roles')->name('roles.')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::get('/create', [RoleController::class, 'create'])->name('create');
        Route::post('/', [RoleController::class, 'store'])->name('store');
        Route::get('/{role}', [RoleController::class, 'show'])->name('show')->whereNumber('role');
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('edit')->whereNumber('role');
        Route::put('/{role}', [RoleController::class, 'update'])->name('update')->whereNumber('role');
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy')->whereNumber('role');

        Route::post('/{role}/permissions', [RoleController::class, 'syncPermissions'])->name('sync.permissions')->whereNumber('role');
    });

    Route::middleware('role:admin|super-admin')->prefix('permissions')->name('permissions.')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('index');
        Route::get('/create', [PermissionController::class, 'create'])->name('create');
        Route::post('/', [PermissionController::class, 'store'])->name('store');
        Route::get('/{permission}', [PermissionController::class, 'show'])->name('show')->whereNumber('permission');
        Route::get('/{permission}/edit', [PermissionController::class, 'edit'])->name('edit')->whereNumber('permission');
        Route::put('/{permission}', [PermissionController::class, 'update'])->name('update')->whereNumber('permission');
        Route::delete('/{permission}', [PermissionController::class, 'destroy'])->name('destroy')->whereNumber('permission');
    });

    Route::middleware('role:admin|super-admin')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}', [UserController::class, 'show'])->name('show')->whereNumber('user');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit')->whereNumber('user');
        Route::put('/{user}', [UserController::class, 'update'])->name('update')->whereNumber('user');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy')->whereNumber('user');
        Route::patch('/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('toggle-active')->whereNumber('user');

        Route::post('/{user}/sections', [UserController::class, 'syncSections'])->name('sync.sections')->whereNumber('user');
        Route::post('/{user}/subsections', [UserController::class, 'syncSubsections'])->name('sync.subsections')->whereNumber('user');
    });

});