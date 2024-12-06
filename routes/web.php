<?php

use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\BasketRepoController;
use App\Http\Controllers\BondManagementController;
use App\Http\Controllers\MiborOisController;
use App\Http\Controllers\NdsCallController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\TreasureController;
use App\Http\Controllers\TrepsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.home');
})->name('home');


Auth::routes();

Route::group(['middleware' => ['auth']], function () {


    Route::get('view', function () {
        Artisan::call('view:clear');
        return redirect()->back();
    });

    Route::get('cache', function () {
        Artisan::call('cache:clear');
        return redirect()->back();
    });

    Route::get('route', function () {
        Artisan::call('route:clear');
        return redirect()->back();
    });


//users
    Route::get('users/index', [UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('users/edit/{id?}', [UserController::class, 'edit'])->name('users.edit');
    // Route::post('users/update', [UserController::class, 'update'])->name('users.update');
    Route::get('users/delete/{id?}', [UserController::class, 'delete'])->name('users.delete');
    Route::post('/users/update/{id}', [UserController::class, 'updateInline']);

//Bonds

Route::get('/bonds', [BondManagementController::class, 'index'])->name('bonds.index');
Route::post('/bonds/update/{id}', [BondManagementController::class, 'update'])->name('bonds.update');
Route::get('/bonds/export', [BondManagementController::class, 'export'])->name('bonds.export');
Route::post('/bonds/import', [BondManagementController::class, 'import'])->name('bonds.import');


//market live data
Route::get('/stock-data', [StockController::class, 'getLiveData']);

//market management


// Policy Management
Route::get('/policies/index', [PolicyController::class, 'index'])->name('policies.index');
Route::post('/policies', [PolicyController::class, 'store'])->name('policies.store');
Route::put('/policies/{id}', [PolicyController::class, 'update'])->name('policies.update');
Route::delete('/policies/{id}', [PolicyController::class, 'destroy'])->name('policies.destroy');

// Treasure Management
Route::get('/treasure/index', [TreasureController::class, 'index'])->name('treasure.index');
Route::post('/treasure', [TreasureController::class, 'store'])->name('treasure.store');
Route::put('/treasure/{id}', [TreasureController::class, 'update'])->name('treasure.update');
Route::delete('/treasure/{id}', [TreasureController::class, 'destroy'])->name('treasure.destroy');

// Nds Calls Management
Route::get('/ndsCalls/index', [NdsCallController::class, 'index'])->name('ndsCalls.index');
Route::post('/ndsCalls', [NdsCallController::class, 'store'])->name('ndsCalls.store');
Route::put('/ndsCalls/{id}', [NdsCallController::class, 'update'])->name('ndsCalls.update');
Route::delete('/ndsCalls/{id}', [NdsCallController::class, 'destroy'])->name('ndsCalls.destroy');

// Basket Management
Route::get('/basketRepo/index', [BasketRepoController::class, 'index'])->name('basketRepo.index');
Route::post('/basketRepo', [BasketRepoController::class, 'store'])->name('basketRepo.store');
Route::put('/basketRepo/{id}', [BasketRepoController::class, 'update'])->name('basketRepo.update');
Route::delete('/basketRepo/{id}', [BasketRepoController::class, 'destroy'])->name('basketRepo.destroy');

// Treps Management
Route::get('/treps/index', [TrepsController::class, 'index'])->name('treps.index');
Route::post('/treps', [TrepsController::class, 'store'])->name('treps.store');
Route::put('/treps/{id}', [TrepsController::class, 'update'])->name('treps.update');
Route::delete('/treps/{id}', [TrepsController::class, 'destroy'])->name('treps.destroy');

// MIBOR OIS
Route::get('/mibor/index', [MiborOisController::class, 'index'])->name('mibor.index');
Route::post('/mibor', [MiborOisController::class, 'store'])->name('mibor.store');
Route::put('/mibor/{id}', [MiborOisController::class, 'update'])->name('mibor.update');
Route::delete('/mibor/{id}', [MiborOisController::class, 'destroy'])->name('mibor.destroy');



});
