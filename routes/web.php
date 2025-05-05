<?php // web.php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController; // Assurez-vous qu'il existe et est correct
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\TaskController as ControllersTaskController;
use App\Models\User;

/* ... comments ... */

Route::get('/', function () {
    return view('welcome');
});

// --- Routes Utilisateur Standard ---
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
    // Le login user est probablement dans auth.php
    Route::view('/forgot-password','auth.forgot-password')->name('password.request');
    Route::post('/forgot-password',[ResetPasswordController::class,'passwordEmail']);
    Route::get('/reset-password/{token}', [ResetPasswordController::class,'passwordReset'])->name('password.reset');
    Route::post('/reset-password',[ResetPasswordController::class,'passwordUpdate'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Les autres routes liées à l'auth user (vérification email, etc.) sont dans auth.php
    

});
// --- Routes Admin ---

// Routes publiques/guest Admin (Login/Register) - Mieux dans auth.php ou ici si préférez
Route::middleware('guest:admin')->group(function () {
    
    Route::get('/admin/register', [AdminController::class, 'showRegisterForm'])->name('admin.registerForm');
    Route::post('/admin/register', [AdminController::class, 'register'])->name('admin.register');
});


// Routes Admin Authentifié
Route::middleware(['auth:admin'])->group(function () {

    Route::get('/dashboard/admin', function () {
        $users = User::all();
        return view('Dashboard.Admin.dashboard', compact('users'));
    })->name('dashboard.admin');

    Route::get('/admin/profile', [ProfileController::class, 'editAdmin'])->name('admin.profile.edit');
    Route::patch('/admin/profile', [AdminController::class, 'updateAdmin'])->name('admin.profile.update');
    Route::delete('/admin/profile', [ProfileController::class, 'destroyAdmin'])->name('admin.profile.destroy');


    // Autres routes admin
    Route::get('employee/tasks/{id}',[ControllersTaskController::class,'getTasks'])->name('employee.tasks');
});

