<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketsController;
use App\Http\Controllers\UserController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('login', [AuthController::class,'login']);
Route::post('registration', [AuthController::class,'registration']);

Route::middleware(['jwt.auth'])->group(function () {

    Route::prefix('tickets')->group(function () {

        // GET api/tickets/
        Route::get('/',[TicketsController::class,'index']);
        // POST api/tickets/
        Route::post('/', [TicketsController::class,'createTicket']);
        // DELETE api/tickets/{id}
        Route::delete('/{id}', [TicketsController::class,'deleteTicket']);


    });

    Route::prefix('users')->group(function () {

        // GET api/users/
        Route::get('/',[UserController::class,'index']);
        // PUT api/users/
        Route::put('/{id}', [UserController::class,'updateUser']);
        // DELETE api/users/
        Route::delete('/{id}', [UserController::class,'deleteUser']);

    });

});
