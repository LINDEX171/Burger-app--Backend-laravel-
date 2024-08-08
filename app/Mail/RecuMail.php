<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Commande1;

class RecuMail extends Mailable
{
    use Queueable, SerializesModels;

    public $commande;
    public $invoiceUrl;

    public function __construct(Commande1 $commande, $invoiceUrl)
    {
        $this->commande = $commande;
        $this->invoiceUrl = $invoiceUrl;
    }

    public function build()
    {
        return $this->view('emails.recu')
                    ->with([
                        'commande' => $this->commande,
                        'invoiceUrl' => $this->invoiceUrl,
                    ])
                    ->subject('Votre reçu de commande');
    }
}
