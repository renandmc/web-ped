<?php

use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\User\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('profile', [ProfileController::class, 'index'])->name('admin.user.profile');
        Route::get('edit-profile', [ProfileController::class, 'editProfile'])->name('admin.user.edit-profile');
        Route::put('update-profile', [ProfileController::class, 'updateProfile'])->name('admin.user.update-profile');
        Route::get('edit-password', [ProfileController::class, 'editPassword'])->name('admin.user.edit-password');
        Route::put('update-password', [ProfileController::class, 'updatePassword'])->name('admin.user.update-password');
    });
    Route::resource('companies', CompanyController::class);
});
