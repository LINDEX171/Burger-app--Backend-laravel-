<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Customer;
use App\Models\User;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        // Récupère l'ID du client depuis la requête
        $clientId = $request->input('id');

        // Récupère les informations du client depuis la base de données
        $client = User::findOrFail($clientId); // Supposons que ton modèle Client soit configuré

        // Envoie l'email
        Mail::send('emails.order_ready', ['client_name' => $client->name], function($message) use ($client) {
            $message->to($client->email)
                    ->subject('Votre commande est prête');
        });

        return response()->json(['message' => 'Email envoyé avec succès!']);
    }
}
