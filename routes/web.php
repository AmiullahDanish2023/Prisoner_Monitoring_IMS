<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Frontend\WelcomeController;

use App\Http\Controllers\suspectController;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// Route::get('/',  [WelcomeController::class, 'welcome'])->middleware(['setlocale'])->name('welcome');

Route::get('/', function () {
  return view('auth.login');
})->name('login');


Auth::routes();

Route::get('en', [LanguageController::class, 'en'])->name('en');
Route::get('fa', [LanguageController::class, 'fa'])->name('fa');
Route::get('pa', [LanguageController::class, 'pa'])->name('pa');

// Change the Landing page Localization
Route::get('site/en', [WelcomeController::class, 'en'])->name('site.en');
Route::get('site/fa', [WelcomeController::class, 'fa'])->name('site.fa');
Route::get('site/pa', [WelcomeController::class, 'pa'])->name('site.pa');



Route::get('/home', [HomeController::class, 'index'])->middleware(['auth', 'setlocale'])->name('home');



# --------------------------------- Users Routes -------------------------------------------------------------------
Route::get('users', [UserController::class, 'index'])->middleware(['auth', 'setlocale'])->name('users.index');
Route::post('users-store', [UserController::class, 'store'])->middleware(['auth', 'setlocale'])->name('users.store');
Route::post('users-update', [UserController::class, 'update'])->middleware(['auth', 'setlocale'])->name('users.update');
Route::get('user-delete/{id}', [UserController::class, 'destroy'])->middleware(['auth', 'setlocale'])->name('users.delete');
Route::get('profile', [UserController::class, 'profile'])->middleware(['auth', 'setlocale'])->name('profile');
Route::post('update/profile', [UserController::class, 'update_profile'])->middleware(['auth', 'setlocale'])->name('update.profile');
Route::post('change_password', [UserController::class, 'change_password'])->middleware(['auth', 'setlocale'])->name('change-user-password');
Route::get('users/roles', [UserController::class, 'roles'])->middleware(['auth', 'setlocale'])->name('user.roles');
Route::post('users/role-store', [UserController::class, 'role_store'])->middleware(['auth', 'setlocale'])->name('role.store');
Route::get('users/role-edit', [UserController::class, 'role_edit'])->middleware(['auth', 'setlocale'])->name('role.edit');
Route::post('users/role-update', [UserController::class, 'role_update'])->middleware(['auth', 'setlocale'])->name('role.update');
# --------------------------------- End Users Routes ------------------------------------------------------------------

# --------------------------------- suspects Routes -------------------------------------------------------------------
route::get('suspects', [suspectController::class, 'index'])->middleware(['auth', 'setlocale'])->name('suspects.index');
route::post('suspects/store', [suspectController::class, 'store'])->middleware(['auth', 'setlocale'])->name('suspects.store');
Route::get('suspects/list', [SuspectController::class, 'show'])->name('suspects.list')->middleware(['auth', 'setlocale']);
Route::get('suspects/edit/{id}', [SuspectController::class, 'edit'])->name('suspects.edit')->middleware(['auth', 'setlocale']);
Route::post('suspects/update/{id}', [SuspectController::class, 'update'])->name('suspects.update')->middleware(['auth', 'setlocale']);
Route::get('suspects/destroy/{id}', [SuspectController::class, 'destroy'])->name('suspects.destroy')->middleware(['auth', 'setlocale']);
Route::get('/suspects/details/{id}', [SuspectController::class, 'details'])->name('details')->middleware(['auth', 'setlocale']);
Route::post('/suspects/release', [SuspectController::class, 'release'])->name('suspects.release')->middleware(['auth', 'setlocale']);
  
 






   
  
# --------------------------------- End suspects Routes ------------------------------------------------------------------
