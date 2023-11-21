<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CopyController;
use App\Http\Controllers\LendingController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//admin férhet hozzá
Route::middleware( ['admin'])->group(function () {
    Route::apiResource('/users', UserController::class);
});

//bejelentkezett felhasználó
Route::middleware('auth.basic')->group(function () {
    
    Route::apiResource('/copies', CopyController::class);
    //Route::post('/api/lendings', LendingController::class)->except('put');
    Route::post('/reservations', [ReservationController::class, 'store']);
    Route::patch('/reservations/{user_id}/{book_id}/{start}', [ReservationController::class, 'update']);//->except('put');

    Route::get('/reservations/{user_id}/{book_id}/{start}', [ReservationController::class, 'show']);
    
    //lekérdezések
    //with
    Route::get('/with/book_copy', [BookController::class, 'bookCopy']);
    Route::get('/with/lending_user', [LendingController::class, 'lendingUser']);
    Route::get('/with/lending_user2', [LendingController::class, 'lendingUser2']);
    Route::get('/with/copy_book_lending', [CopyController::class, 'copyBookLending']);
    Route::get('/with/user_l_r', [UserController::class, 'userLR']);
});

//bejelentkezés nélkül is hozzáférhet
Route::apiResource('/books', BookController::class);
Route::patch('/user_password/{id}', [UserController::class, 'updatePassword']);
Route::delete('/lendings/{user_id}/{copy_id}/{start}', [LendingController::class, 'destroy']);
