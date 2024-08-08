<!DOCTYPE html>
<html>
<head>
    <title>Confirmation de votre commande</title>
</head>
<body>
    <h1>Bonjour {{ $commande->nom }} {{ $commande->prenom }},</h1>
    <p>Votre commande est terminée.</p>
    {{-- <p><a href="{{ $invoiceUrl }}" target="_blank">Télécharger la facture</a></p> --}}
    <p>Merci pour votre commande !</p>
</body>
</html>
