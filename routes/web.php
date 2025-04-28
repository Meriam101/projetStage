<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\TaskController as ControllersTaskController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [RegisteredUserController::class, 'create'])
     ->middleware('guest')
     ->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

     Route::middleware(['auth'])->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
    // Routes pour le profil de l'ADMINISTRATEUR
    Route::middleware(['auth:admin'])->group(function () {
        // Utilisez un préfixe ou un nom différent pour les URL admin
        Route::get('/admin/profile', [ProfileController::class, 'edit1'])->name('admin.profile.edit'); // Nom différent
        Route::patch('/admin/profile', [ProfileController::class, 'update2'])->name('admin.profile.update'); // Nom différent
        Route::delete('/admin/profile', [ProfileController::class, 'destroy2'])->name('admin.profile.destroy'); 
      
    });

Route::get('/admin/register', [AdminController::class, 'showRegisterForm'])->name('admin.registerForm');
Route::post('/admin/register', [AdminController::class, 'register'])->name('admin.register');

// Ensure the target dashboard route is also correctly defined (looks okay in web.php)
Route::get('/dashboard/admin', function () {
    $users = User::all(); // Make sure User model is imported or use full namespace
    return view('Dashboard.Admin.dashboard', compact('users'));
})->middleware(['auth:admin'])->name('dashboard.admin'); // Removed 'verified' unless admins need email verification
Route::get('employee/tasks/{id}',[ControllersTaskController::class,'getTasks'])
     ->middleware('auth:admin') // Add this line
     ->name('employee.tasks');
  




