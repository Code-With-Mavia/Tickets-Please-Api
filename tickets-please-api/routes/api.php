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
        //GET api/tickets/ticket/{tickets_id}
        Route::get('/ticket/{id}', [TicketsController::class,'getSingleTicketInfo'])->name('tickets.show');
        //GET api/tickets/user/{user_id}
        Route::get('/user/{id}', [TicketsController::class,'getUserTickets']);
        // POST api/tickets/
        Route::post('/', [TicketsController::class,'createTicket']);
        // PATCH api/tickets/{id}
        Route::patch('/{id}', [TicketsController::class,'updateTicket']);
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
        Route::get('/{id}', [UserController::class,'getSingleUser'])->name('users.show');
        // GET api/users/stats/{id}
        Route::get('/stats/{id}', [UserController::class,'ticketUserStats']);
        // PATCH api/users/
        Route::patch('/{id}', [UserController::class,'updateUser'])->name('users.show');
        // DELETE api/users/
        Route::delete('/{id}', [UserController::class,'deleteUser']);
    });

});

?>
