<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        try {
            // Récupérer tous les clients
            $customers = Customer::all();
    
            // Retourner une réponse JSON avec les données
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Clients récupérés avec succès',
                'data' => $customers
            ], 200);
        } catch (\Exception $e) {
            // Retourner une réponse JSON en cas d'erreur
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Erreur lors de la récupération des clients',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    

    // Affiche les détails d'un customer spécifique
    public function show($id)
{
    try {
        // Trouver le client par ID
        $customer = Customer::findOrFail($id);

        // Retourner une réponse JSON avec les données du client
        return response()->json([
            'status_code' => 200,
            'status_message' => 'Client récupéré avec succès',
            'data' => $customer
        ], 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        // Retourner une réponse JSON si le client n'est pas trouvé
        return response()->json([
            'status_code' => 404,
            'status_message' => 'Client non trouvé',
            'error' => $e->getMessage()
        ], 404);
    } catch (\Exception $e) {
        // Retourner une réponse JSON en cas d'erreur générale
        return response()->json([
            'status_code' => 500,
            'status_message' => 'Erreur lors de la récupération du client',
            'error' => $e->getMessage()
        ], 500);
    }
}

    // Crée un nouveau customer
   /* public function store(Request $request)
{
    try {
        // Valider les données de la requête
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'telephone' => 'required|string|max:15|unique:customers,telephone',
        ]);

        // Créer un nouveau client avec les données validées
        $customer = Customer::create($validatedData);

        // Retourner une réponse JSON avec les données du client créé
        return response()->json([
            'status_code' => 201,
            'status_message' => 'Client créé avec succès',
            'data' => $customer
        ], 201);
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Retourner une réponse JSON avec les erreurs de validation
        return response()->json([
            'status_code' => 422,
            'status_message' => 'Erreur de validation',
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        // Retourner une réponse JSON en cas d'erreur générale
        return response()->json([
            'status_code' => 500,
            'status_message' => 'Erreur lors de la création du client',
            'error' => $e->getMessage()
        ], 500);
    }
}
*/

    // Met à jour un customer existant
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $request->validate([
            'nom' => 'sometimes|required|string|max:255',
            'prenom' => 'sometimes|required|string|max:255',
            'telephone' => 'sometimes|required|string|max:15|unique:customers,telephone,' . $customer->id,
        ]);

        $customer->update($request->all());
        return response()->json($customer);
    }

    // Supprime un customer
    public function destroy($id)
    {
        Customer::destroy($id);
        return response()->json(null, 204);
    }
}
