<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\UserCatalogueController;
use App\Http\Middleware\AuthenticateMiddleware;

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


Route::get('/dashboard/index', function () {
    echo('Dashboard ne');
})->middleware(AuthenticateMiddleware::class)->name('dashboard.index');

Route::group(['prefix' => 'user'], function () {
    Route::get('index', [UserController::class, 'index'])->name('user.index')->middleware(AuthenticateMiddleware::class);
    Route::get('create', [UserController::class, 'create'])->name('user.create')->middleware(AuthenticateMiddleware::class);
    Route::post('store', [UserController::class, 'store'])->name('user.store')->middleware(AuthenticateMiddleware::class);
    Route::get('{id}/edit', [UserController::class, 'edit'])->where('id', '[0-9]+')->name('user.edit')->middleware(AuthenticateMiddleware::class);
    Route::post('{id}/update', [UserController::class, 'update'])->where('id', '[0-9]+')->name('user.update')->middleware(AuthenticateMiddleware::class);
    Route::post('{id}/delete', [UserController::class, 'delete'])->where('id', '[0-9]+')->name('user.delete')->middleware(AuthenticateMiddleware::class);

});

Route::group(['prefix' => 'user/catalogue'], function () {
    Route::get('index', [UserCatalogueController::class, 'index'])->name('user.catalogue.index')->middleware(AuthenticateMiddleware::class);
    Route::get('create', [UserCatalogueController::class, 'create'])->name('user.catalogue.create')->middleware(AuthenticateMiddleware::class);
    Route::post('store', [UserCatalogueController::class, 'store'])->name('user.catalogue.store')->middleware(AuthenticateMiddleware::class);
    Route::get('{id}/edit', [UserCatalogueController::class, 'edit'])->where('id', '[0-9]+')->name('user.catalogue.edit')->middleware(AuthenticateMiddleware::class);
    Route::post('{id}/update', [UserCatalogueController::class, 'update'])->where('id', '[0-9]+')->name('user.catalogue.update')->middleware(AuthenticateMiddleware::class);
    Route::post('{id}/delete', [UserCatalogueController::class, 'delete'])->where('id', '[0-9]+')->name('user.catalogue.delete')->middleware(AuthenticateMiddleware::class);

});

Route::get('/admin', [AuthController::class, 'index'])->name('auth.login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
