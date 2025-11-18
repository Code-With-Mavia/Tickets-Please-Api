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
Route::post('logout', [AuthController::class,'logout']);

Route::middleware(['jwt.auth'])->group(function () {

    Route::prefix('tickets')->group(function () {
        // GET api/tickets/
        Route::get('/',[TicketsController::class,'index']);
        //GET api/tickets/stats
        Route::get('/stats', [TicketsController::class,'ticketStats']);
         //GET api/tickets/{user_id}
        Route::get('/{id}', [TicketsController::class,'getUserTickets'])->name('tickets.show');
        // POST api/tickets/
        Route::post('/', [TicketsController::class,'createTicket']);
        // PUT api/tickets/{id}
        Route::put('/{id}', [TicketsController::class,'updateTicket']);
        // DELETE api/tickets/{id}
        Route::delete('/{id}', [TicketsController::class,'deleteTicket']);
    });

    /*optional parameters is always like
    * Route::get('users/{id?}',[UserController::class,'index']])
    */
    Route::prefix('users')->group(function () {
        // GET api/users/
        Route::get('/',[UserController::class,'index']);
        // GET api/users/{id}
        Route::get('/{id}', [UserController::class,'getSingleUser']);
        // GET api/users/stats/{id}
        Route::get('/stats/{id}', [UserController::class,'ticketUserStats']);
        // PUT api/users/
        Route::put('/{id}', [UserController::class,'updateUser']);
        // DELETE api/users/
        Route::delete('/{id}', [UserController::class,'deleteUser']);
    });

});
