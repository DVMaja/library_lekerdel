<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CopyController;
use App\Http\Controllers\LendingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//admin férhet hozzá
Route::middleware( ['admin'])->group(function () {
    Route::apiResource('/api/users', UserController::class);
});

//bejelentkezett felhasználó
Route::middleware('auth.basic')->group(function () {
    
    Route::apiResource('/api/copies', CopyController::class);
    //Route::post('/api/lendings', LendingController::class)->except('put');
    Route::post('/api/reservations', [ReservationController::class, 'store']);
    Route::patch('/api/reservations/{user_id}/{book_id}/{start}', [ReservationController::class, 'update']);//->except('put');

    Route::get('/api/reservations/{user_id}/{book_id}/{start}', [ReservationController::class, 'show']);
    
    //lekérdezések
    //with
    Route::get('/with/book_copy', [BookController::class, 'bookCopy']);
    Route::get('/with/lending_user', [LendingController::class, 'lendingUser']);
    Route::get('/with/lending_user2', [LendingController::class, 'lendingUser2']);
    Route::get('/with/copy_book_lending', [CopyController::class, 'copyBookLending']);
    Route::get('/with/user_l_r', [UserController::class, 'userLR']);
});

//bejelentkezés nélkül is hozzáférhet
Route::apiResource('/api/books', BookController::class);
Route::patch('/api/user_password/{id}', [UserController::class, 'updatePassword']);
Route::delete('/api/lendings/{user_id}/{copy_id}/{start}', [LendingController::class, 'destroy']);

require __DIR__.'/auth.php';
