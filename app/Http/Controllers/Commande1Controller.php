<?php

namespace App\Http\Controllers;

use App\Mail\CommandeConfirmationMail;
use App\Mail\RecuMail;
use App\Models\Commande1;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class Commande1Controller extends Controller
{
    public function index(Request $request)
{
    $query = Commande1::with('burger');

    if ($request->has('statut') && $request->input('statut') !== '') {
        $statut = $request->input('statut');
        $query->where('statut', $statut);
    }

    $commandes = $query->get();
    return response()->json($commandes);
}

    

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'burger_id' => 'required|exists:burgers,id',
            'statut' => 'required|in:en_attente,terminee,annulee,payee',
            'date_commande' => 'required|date',
        ]);

        $commande = Commande1::create($request->all());
        return response()->json($commande, 201);
    }

    public function show($id)
    {
        $commande = Commande1::findOrFail($id);
        return response()->json($commande);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'sometimes|required|string|max:255',
            'prenom' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|max:255',
            'burger_id' => 'sometimes|required|exists:burgers,id',
            'statut' => 'sometimes|required|in:en_attente,terminee,annulee,payee',
            'date_commande' => 'sometimes|required|date',
        ]);

        $commande = Commande1::findOrFail($id);
        $commande->update($request->all());
        return response()->json($commande);
    }

    public function destroy($id)
    {
        $commande = Commande1::findOrFail($id);
        $commande->delete();
        return response()->json(null, 204);
    }

    public function sendEmail($id)
{
    // Récupérer la commande par ID
    $commande = Commande1::findOrFail($id);

    // Vérifier si la commande est en statut 'terminée'
    if ($commande->statut !== 'terminee') {
        return response()->json(['message' => 'La commande n\'est pas encore terminée.'], 400);
    }

    // Générer l'URL pour télécharger la facture
    $invoiceUrl = url('api/facture/' . $commande->id);

    // Envoi de l'e-mail de confirmation
    Mail::to($commande->email)->send(new CommandeConfirmationMail($commande, $invoiceUrl));

    return response()->json(['message' => 'E-mail envoyé avec succès !']);
}


public function sendEmail1($id)
{
    // Récupérer la commande par ID
    $commande = Commande1::findOrFail($id);

    // Vérifier si la commande est en statut 'payee'
    if ($commande->statut !== 'payee') {
        return response()->json(['message' => 'La commande n\'est pas encore payee.'], 400);
    }

    // Générer l'URL pour télécharger la facture
    $invoiceUrl = url('api/facture/' . $commande->id);

    // Envoi de l'e-mail de confirmation
    Mail::to($commande->email)->send(new RecuMail($commande, $invoiceUrl));

    return response()->json(['message' => 'E-mail envoyé avec succès !']);
}





public function getStatusCounts()
    {
        try {
            // Log les données de la requête pour déboguer
            Log::info('Récupération des statistiques des commandes');

            $today = Carbon::today();
            // Comptage des commandes en cours et terminées
            $enCoursCount = Commande1::where('statut', 'en_cours')->count();
            $termineeCount = Commande1::where('statut', 'terminee')->count();
            $payeeCount = Commande1::where('statut', 'payee')->count();
            $annuleeCount = Commande1::where('statut', 'annulee')->count();
            $commandesToday = Commande1::whereDate('created_at', $today)->count();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Statistiques récupérées avec succès',
                'data' => [
                    'en_cours' => $enCoursCount,
                    'terminee' => $termineeCount,
                    'payeeCount' => $payeeCount,
                    'annuleeCount' => $annuleeCount,
                    'commandes_today' => $commandesToday, 
                ]
            ], 200);
        } catch (Exception $e) {
            Log::error('Erreur lors de la récupération des statistiques : ' . $e->getMessage());

            return response()->json([
                'status_code' => 500,
                'status_message' => 'Erreur lors de la récupération des statistiques',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function searchByBurger($burgerId)
    {
        $commandes = Commande1::where('burger_id', $burgerId)->get();
        return response()->json($commandes);
    }

    public function searchByDate($date)
{
    $commandes = Commande1::whereDate('created_at', $date)->get();
    return response()->json($commandes);
}


public function searchByStatus($status)
{
    $commandes = Commande1::where('statut', $status)->get();
    return response()->json($commandes);
}

public function searchByClient($nom)
{
    $commandes = Commande1::where('nom', $nom)
                          ->get();
    return response()->json($commandes);
}



    
}
