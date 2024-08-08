<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BurgerController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\Commande1Controller;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FactureController;
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
Route::get('burgersreactive', [BurgerController::class, 'reactive']);
Route::post('addburgers', [BurgerController::class, 'store']);
Route::get('burgers/{id}', [BurgerController::class, 'show']);
Route::put('burgers/{id}', [BurgerController::class, 'update']);
Route::delete('burgers/{id}', [BurgerController::class, 'archive']);
Route::put('burgers/{id}/restore', [BurgerController::class, 'restore']);
Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);
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
Route::post('addcommande', [CommandeController::class, 'store']);
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
   // Route::post('logout', [AuthController::class, 'logout']);
   Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout']);
});



Route::get('commande1', [Commande1Controller::class, 'index']);

// Créer une nouvelle commande
Route::post('commande1', [Commande1Controller::class, 'store']);

// Afficher une commande spécifique
Route::get('commande1/{id}', [Commande1Controller::class, 'show']);

// Mettre à jour une commande spécifique
Route::put('commande1/{id}', [Commande1Controller::class, 'update']);

// Supprimer une commande spécifique
Route::delete('commande1/{id}', [Commande1Controller::class, 'destroy']);

Route::put('commande1/{id}/send-email', [Commande1Controller::class, 'sendEmail'])
    ->name('commande.sendEmail');

    Route::put('commande1/{id}/send-email1', [Commande1Controller::class, 'sendEmail1'])
    ->name('commande.sendEmail1');


Route::get('facture/{id}', [FactureController::class, 'generateInvoice'])->name('facture.generate');
Route::get('facture1/{id}', [FactureController::class, 'generateInvoice1'])->name('facture.generate1');

Route::get('statut', [Commande1Controller::class, 'getStatusCounts']);

Route::get('commande1/search/burger/{burgerId}', [Commande1Controller::class, 'searchByBurger']);

Route::get('commande1/search/date/{date}', [Commande1Controller::class, 'searchByDate']);

Route::get('commande1/search/status/{status}', [Commande1Controller::class, 'searchByStatus']);

Route::get('commande1/search/client/{nom}', [Commande1Controller::class, 'searchByClient']);



