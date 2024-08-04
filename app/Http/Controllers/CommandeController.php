<?php

namespace App\Http\Controllers;

use App\Models\Burger;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CommandeController extends Controller
{
    // Affiche la liste de toutes les commandes
    public function index()
    {
        $commandes = Commande::with('customer', 'burger')->get();
        return response()->json($commandes);
    }

    // Affiche les détails d'une commande spécifique
    public function show($id)
    {
        $commande = Commande::with('customer', 'burger')->findOrFail($id);
        return response()->json($commande);
    }

    // Crée une nouvelle commande
    public function store(Request $request)
    {
        // Valider la requête
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'burger_id' => 'required|exists:burgers,id',
            'date_commande' => 'required|date',
        ]);

        // Récupérer le prix du burger
        $burger = Burger::find($validatedData['burger_id']);
        if (!$burger) {
            throw ValidationException::withMessages(['burger_id' => 'Burger non trouvé.']);
        }

        // Calculer le montant total
        $montant_total = $burger->price;

        // Créer la commande
        $commande = Commande::create([
            'customer_id' => $validatedData['customer_id'],
            'burger_id' => $validatedData['burger_id'],
            'statut' => 'en_attente',
            'montant_total' => $montant_total,
            'date_commande' => $validatedData['date_commande'],
        ]);

        // Retourner la réponse
        return response()->json($commande, 201);
    }

    public function updateStatut(Request $request, $id)
    {
        // Trouver la commande par ID
        $commande = Commande::findOrFail($id);

        // Valider le statut
        $request->validate([
            'statut' => 'required|in:en_attente,terminee,annulee,payee',
        ]);

        // Mettre à jour le statut de la commande
        $commande->statut = $request->input('statut');
        $commande->save();

        // Retourner la réponse
        return response()->json($commande);
    }

    // Met à jour une commande existante
    public function update(Request $request, $id)
    {
        $commande = Commande::findOrFail($id);

        $request->validate([
            'statut' => 'sometimes|required|in:en_attente,terminee,annulee,payee',
            'montant_total' => 'sometimes|required|numeric',
            'date_commande' => 'sometimes|required|date',
        ]);

        $commande->update($request->all());
        return response()->json($commande);
    }

    // Supprime une commande
    public function destroy($id)
    {
        Commande::destroy($id);
        return response()->json(null, 204);
    }

    

}