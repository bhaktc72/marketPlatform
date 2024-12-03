<?php


use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.home');
})->name('home');


Auth::routes();


//users
    Route::get('users/index', [UserController::class, 'index'])->name('users.index');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('users/edit/{id?}', [UserController::class, 'edit'])->name('users.edit');
    Route::post('users/update', [UserController::class, 'update'])->name('users.update');
    Route::get('users/delete/{id?}', [UserController::class, 'delete'])->name('users.delete');
