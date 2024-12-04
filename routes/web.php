<?php

use App\Http\Controllers\BondManagementController;
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





});
