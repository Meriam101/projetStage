<?php

use App\Http\Controllers\Admin\Auth\AdminNewPasswordController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\User\Auth\UserNewPasswordController;

// Routes accessibles aux invités uniquement
Route::middleware('guest')->group(function () {
    Route::get('/User/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.user');
    Route::post('/login/admin', [AdminController::class, 'login'])->name('login.admin');
});
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

// Pour les utilisateurs normaux


// Pour les admins
// Route::middleware('guest:admin')->group(function () {
//     Route::get('/admin/forgot-password', [PasswordResetLinkController::class, 'createAdmin'])->name('admin.password.request');
//     Route::post('/admin/forgot-password', [PasswordResetLinkController::class, 'storeAdmin'])->name('admin.password.email');
// });
// Route::middleware('guest')->group(function () {
//     Route::get('/forgot-password', [PasswordResetLinkController::class, 'createUser'])->name('user.password.request');
//     Route::post('/forgot-password', [PasswordResetLinkController::class, 'storeUser'])->name('user.password.email');
// });

// Envoi du lien par e-mail
Route::post('/admin/forgot-password', [PasswordResetLinkController::class, 'store'])
->middleware('guest:admin')
->name('admin.password.email');

// // Formulaire de réinitialisation avec token
Route::get('/admin/reset-password/{token}', [NewPasswordController::class, 'create'])
->middleware('guest:admin')
->name('admin.password.reset');

// Traitement de la soumission du nouveau mot de passe
// Route::post('/admin/reset-password', [NewPasswordController::class, 'store'])
// ->middleware('guest:admin')
// ->name('admin.password.update');


// Route::get('admin/reset-password/{token}', [AdminNewPasswordController::class, 'create'])
//     ->name('admin.password.reset');

// Route::get('user/reset-password/{token}', [UserNewPasswordController::class, 'create'])
//     ->name('user.password.reset');

Route::middleware('auth')->group(function () {
    Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('verify-email', EmailVerificationPromptController::class)->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')->name('verification.send');
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
});


// --- Routes Admin Authentifié ---
Route::middleware('auth:admin')->group(function () {
    // Admin Logout
    Route::post('/logout/admin', [AdminController::class, 'destroy'])->name('logout.admin');
    // Admin Password Update (Utilisé par le formulaire admin)
    Route::put('/admin/password', [AdminController::class, 'updatePassword'])->name('admin.password.update'); // Route déplacée ici


   
});
