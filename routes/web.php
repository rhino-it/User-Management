<?php

use Illuminate\Support\Facades\Route;
use Admin\UserController;

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
    return view('index');
});


// Admin Routes
Route::prefix('admin')->middleware(['auth','auth.isAdmin'])->name('admin.')->group(function (){

    //Route::resource('/admin/user','Admin\UserController');
    Route::resource('/users',UserController::class);
});
