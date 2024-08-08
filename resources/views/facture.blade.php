<!DOCTYPE html>
<html>
<head>
    <title>Facture</title>
    <style>
        /* Ajoutez des styles pour la facture ici */
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: auto;
        }
        .header, .footer {
            text-align: center;
            margin-bottom: 20px;
        }
        .details {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Facture</h1>
            <p>Téléphone : 123-456-7890</p>
        </div>

        <div class="details">
            <h2>Client</h2>
            <p>Nom : {{ $commande->nom }}</p>
            <p>Prénom : {{ $commande->prenom }}</p>
            <p>Email : {{ $commande->email }}</p>
        </div>

        <h2>Détails de la Commande</h2>
        <table>
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Prix Unitaire</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <!-- Exemple statique, vous devrez adapter cette partie selon vos données -->
                <tr>
                    <td>{{ $commande->burger->name }}</td>
                    <td>1</td>
                    <td>{{ $commande->burger->price }}</td>
                    <td>{{ $commande->burger->price }}</td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            <p>Total : {{ $commande->burger->price }} </p>
            <p>Date de Commande : {{ $commande->date_commande }}</p>
        </div>
    </div>
</body>
</html>
