<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BurgerController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
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
Route::get('burgers', [BurgerController::class, 'index']);
Route::post('addburgers', [BurgerController::class, 'store']);
Route::get('burgers/{id}', [BurgerController::class, 'update']);
Route::put('burgers/{id}', [BurgerController::class, 'update']);
Route::delete('burgers/{id}', [BurgerController::class, 'archive']);
Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('updateuser/{id}', [\App\Http\Controllers\AuthController::class, 'update']);
Route::post('sendEmail', [\App\Http\Controllers\EmailController::class, 'sendEmail'])->name('sendEmail');


Route::middleware('auth:sanctum')->get('/user-details', [AuthController::class, 'userDetails']);

//CLIENT
Route::get('customers', [CustomerController::class, 'index']);
Route::get('customers/{id}', [CustomerController::class, 'show']);
Route::post('addcustomers', [CustomerController::class, 'store']);
Route::put('updatecustomers/{id}', [CustomerController::class, 'update']);
Route::delete('deletecustomers/{id}', [CustomerController::class, 'destroy']);



//commande

Route::get('commandes', [CommandeController::class, 'index']);
Route::get('commandes/{id}', [CommandeController::class, 'show']);
Route::post('addcommande', [CommandeController::class, 'store'])->middleware('auth:sanctum');
Route::put('commandes/{id}/statut', [CommandeController::class, 'updateStatut']);
Route::put('updatecommandes/{id}', [CommandeController::class, 'update']);
Route::delete('deletecommandes/{id}', [CommandeController::class, 'destroy']);

    // Routes accessibles uniquement aux administrateurs
Route::middleware(['role:admin'])->group(function () {
    Route::get('/testadmin', function () {
        $role = auth()->user()->role->name;
        return "Wow un $role !";
    })->name('testadmin');
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [AuthController::class, 'user']);
    Route::post('logout', [AuthController::class, 'logout']);
});
