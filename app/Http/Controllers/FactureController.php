<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande1;
use Barryvdh\DomPDF\Facade\Pdf; // Assurez-vous d'utiliser la bonne façade

class FactureController extends Controller
{
    public function generateInvoice($id)
    {
        // Récupérer la commande par ID
        $commande = Commande1::findOrFail($id);

        // Préparer les données pour la vue de la facture
        $data = [
            'commande' => $commande
        ];

        // Générer le PDF avec les données de la facture
        $pdf = Pdf::loadView('facture', $data);

        // Télécharger le PDF
        return $pdf->download('facture_' . $commande->id . '.pdf');
    }


    public function generateInvoice1($id)
    {
        // Récupérer la commande par ID
        $commande = Commande1::findOrFail($id);

        // Préparer les données pour la vue de la facture
        $data = [
            'commande' => $commande
        ];

        // Générer le PDF avec les données de la facture
        $pdf = Pdf::loadView('facture', $data);

        // Télécharger le PDF
        return $pdf->download('facture_' . $commande->id . '.pdf');
    }
}
