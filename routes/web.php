<?php

use App\Http\Controllers\Admin\BuyController;
use App\Http\Controllers\Admin\CompanyAddressController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SellController;
use App\Http\Controllers\Admin\User\ProfileController;
use App\Http\Controllers\HomeController;
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

Route::get('/home', [HomeController::class, 'index'])
    ->name('home');

Route::prefix('admin')
    ->middleware('auth')
    ->group(function () {
        Route::prefix('user')
            ->name('user')
            ->group(function () {
                Route::get('profile', [ProfileController::class, 'index'])
                    ->name('.profile');
                Route::get('edit-profile', [ProfileController::class, 'editProfile'])
                    ->name('.edit-profile');
                Route::put('update-profile', [ProfileController::class, 'updateProfile'])
                    ->name('.update-profile');
                Route::get('edit-password', [ProfileController::class, 'editPassword'])
                    ->name('.edit-password');
                Route::put('update-password', [ProfileController::class, 'updatePassword'])
                    ->name('.update-password');
            });
        Route::resource('companies', CompanyController::class);
        Route::get('companies/{company}/buy', [BuyController::class, 'index'])
            ->name('buy.index');
        Route::get('companies/{company}/sell', [SellController::class, 'index'])
            ->name('sell.index');
        Route::resource('companies.adresses', CompanyAddressController::class)
            ->only(['store', 'destroy'])
            ->shallow();
        Route::resource('companies.products', ProductController::class)
            ->shallow();
        Route::get('companies/partners/select-company', [PartnerController::class, 'selectCompany'])
            ->name('companies.partners.select-company');
        Route::resource('companies.partners', PartnerController::class)
            ->shallow();
    });
