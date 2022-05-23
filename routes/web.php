<?php

use App\Http\Controllers\Admin\BuyController;
use App\Http\Controllers\Admin\CompanyAddressController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
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

//Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('buy', [BuyController::class, 'index'])->name('buy');
    Route::get('buy/{buyer}/from/{seller}', [BuyController::class, 'products'])->name('buy.products')->missing(function() {
        return redirect()->route('buy');
    });
    Route::get('buy/add/{product}', [BuyController::class, 'addToCart'])->name('buy.add')->missing(function() {
        return redirect()->route('buy');
    });
    Route::delete('buy/remove', [BuyController::class, 'remove'])->name('buy.remove');
    Route::delete('buy/removeAll', [BuyController::class, 'removeAll'])->name('buy.removeAll');
    Route::get('buy/{buyer}/from/{seller}/checkout', [BuyController::class, 'checkout'])->name('buy.checkout')->missing(function() {
        return redirect()->route('buy');
    });
    Route::post('buy/{buyer}/from/{seller}/checkout', [BuyController::class, 'confirm'])->name('buy.confirm')->missing(function() {
        return redirect()->route('buy');
    });
    //Route::get('sell', [SellController::class, 'index'])->name('sell');
    Route::prefix('orders')->name('orders')->group(function () {
        Route::get('sent', [OrderController::class, 'sent'])->name('.sent');
        Route::get('sent/{order}', [OrderController::class, 'details'])->name('.sent.details')->missing(function() {
            return redirect()->route('orders.sent');
        });
        Route::get('received', [OrderController::class, 'received'])->name('.received');
        Route::get('received/{order}', [OrderController::class, 'details'])->name('.received.details')->missing(function() {
            return redirect()->route('orders.received');
        });
    });
    Route::resource('companies', CompanyController::class);
    Route::resource('companies.adresses', CompanyAddressController::class)->only(['store', 'destroy'])->shallow();
    Route::resource('companies.products', ProductController::class)->shallow();
    Route::prefix('partners')->name('partners')->group(function () {
        Route::get('approve', [PartnerController::class, 'approve'])->name('.approve');
        Route::get('create', [PartnerController::class, 'create'])->name('.create');
        Route::post('/', [PartnerController::class, 'store'])->name('.store');
        Route::put('/', [PartnerController::class, 'update'])->name('.update');
        Route::delete('/', [PartnerController::class, 'destroy'])->name('.destroy');
    });
    Route::prefix('user')->name('user')->group(function () {
        Route::get('profile', [ProfileController::class, 'index'])->name('.profile');
        Route::get('edit-profile', [ProfileController::class, 'editProfile'])->name('.edit-profile');
        Route::put('update-profile', [ProfileController::class, 'updateProfile'])->name('.update-profile');
        Route::get('edit-password', [ProfileController::class, 'editPassword'])->name('.edit-password');
        Route::put('update-password', [ProfileController::class, 'updatePassword'])->name('.update-password');
    });
});
