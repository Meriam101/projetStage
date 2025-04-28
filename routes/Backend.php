<?php

use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\SectionController;
use App\Http\Controllers\TaskController;
use App\Models\User;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/Dashboard_Admin',[DashboardController::class,'index'])->name('admin.login');
//Ltr Mcamara 

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){
        //############################# dashboard user ###################
        Route::get('/dashboard/user', function () {
            return view('Dashboard.User.dashboard');
        })->middleware(['auth', 'verified'])->name('dashboard.user');
        //############################# end dashboard user ###################
                //############################# dashboard admin ###################


Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
// Changez GET en POST pour la route de store
Route::post('/tasks', [TaskController::class, 'store'])
     ->middleware(['auth', 'verified'])
     ->name('tasks.store');
     
Route::patch('/tasks/{id}/complete', [TaskController::class, 'markComplete'])->middleware(['auth', 'verified']);
Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->middleware(['auth', 'verified']);
Route::get('/admin/register', [AdminController::class, 'showRegisterForm'])->name('admin.registerForm');

// Enregistrer un nouvel admin
Route::post('/admin/register', [AdminController::class, 'register'])->name('admin.register');
Route::get('/dashboard/admin', function () {
            $users = User::all();
            return view('Dashboard.Admin.dashboard',compact('users'));
        })->middleware(['auth:admin', 'verified'])->name('dashboard.admin');
     //############################# end dashboard admin ###################
      

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

        require __DIR__.'/auth.php';

    });


