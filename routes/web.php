<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\RegisterProductController;
use App\Http\Controllers\ShoppingController;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', [ShoppingController::class, 'index'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [ShoppingController::class, 'index'])->name('dashboard');

    //Registrar Clientes
    Route::get('/registerClient', [ClientController::class, 'index'])->name('client.registerClient');
    Route::post('/registerClient', [ClientController::class, 'store'])->name('client.store');
    Route::get('/client/{id}', [ClientController::class, 'show']);

    //Registrar Produtos
    Route::get('/registerProducts', [RegisterProductController::class, 'index'])->name('product.registerProducts');
    Route::post('/registerProducts', [RegisterProductController::class, 'store'])->name('product.store');
    Route::get('/product/{id}', [RegisterProductController::class, 'show']);

});



require __DIR__.'/auth.php';
