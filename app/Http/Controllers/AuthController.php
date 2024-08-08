<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
{
    try {
        // Validation des données de la requête
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
           'role_id' => 'nullable|integer|exists:roles,id', // Le rôle est optionnel
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|max:15|unique:customers,telephone',
        ]);

         // Utiliser role_id ou 2 par défaut
         $role_id = $request->role_id ?: 2;

        // Création du nouvel utilisateur
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $role_id, 
        ]);


        Customer::create([
            'user_id' => $user->id,
            'nom' => $request->name,
            'prenom' => $request->prenom, // ou obtenez ce champ depuis la requête
            'telephone' => $request->telephone, // ou obtenez ce champ depuis la requête
        ]);

        // Création d'un jeton d'authentification pour l'utilisateur
        $token = $user->createToken('auth_token')->plainTextToken;

        // Retour de la réponse JSON avec le jeton
        return response()->json([
            'status_code' => 201,
            'status_message' => 'Utilisateur créé avec succès',
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);

    } catch (\Illuminate\Validation\ValidationException $e) {
        // Gestion des erreurs de validation
        return response()->json([
            'status_code' => 422,
            'status_message' => 'Erreur de validation',
            'errors' => $e->errors()
        ], 422);

    } catch (\Exception $e) {
        // Gestion des autres erreurs
        return response()->json([
            'status_code' => 500,
            'status_message' => 'Une erreur est survenue',
            'error_message' => $e->getMessage()
        ], 500);
    }
}


public function login(Request $request)
{
    try {
        // Validation des données de la requête
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Tentative de connexion de l'utilisateur
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status_code' => 401,
                'status_message' => 'Détails de connexion invalides'
            ], 401);
        }
        
        // Récupération de l'utilisateur et génération du jeton
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;
        $cookie = cookie('jwt', $token, 600000 * 24);

        // Retour de la réponse JSON avec le jeton
        return response([
            'message'=>'success',
            'token'=>$token,
            'user'=>$user,
        ])->withCookie($cookie);

    } catch (\Illuminate\Validation\ValidationException $e) {
        // Gestion des erreurs de validation
        return response()->json([
            'status_code' => 422,
            'status_message' => 'Erreur de validation',
            'errors' => $e->errors()
        ], 422);

    } catch (\Exception $e) {
        // Gestion des autres erreurs
        return response()->json([
            'status_code' => 500,
            'status_message' => 'Une erreur est survenue',
            'error_message' => $e->getMessage()
        ], 500);
    }
}

public function user(){
    return Auth::user();
}



public function logout(Request $request)
{
    try {
        // Révocation de tous les jetons d'authentification de l'utilisateur actuel
        $request->user()->tokens()->delete();

        // Retour de la réponse JSON avec un message de succès
        return response()->json([
            'status_code' => 200,
            'status_message' => 'Déconnexion réussie'
        ]);

    } catch (\Exception $e) {
        // Gestion des autres erreurs
        return response()->json([
            'status_code' => 500,
            'status_message' => 'Une erreur est survenue lors de la déconnexion',
            'error_message' => $e->getMessage()
        ], 500);
    }
}



   

}

