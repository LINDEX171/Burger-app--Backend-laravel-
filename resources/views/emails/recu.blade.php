<!DOCTYPE html>
<html>
<head>
    <title> votre Recu</title>
</head>
<body>
    <h1>Bonjour {{ $commande->nom }} {{ $commande->prenom }},</h1>
    <p>Vous pouvez télécharger votre facture en cliquant sur le lien ci-dessous :</p>
    <p><a href="{{ $invoiceUrl }}" target="_blank">Télécharger la facture</a></p>
    <p>Merci pour votre commande !</p>
</body>
</html>
