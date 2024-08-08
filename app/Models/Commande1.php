<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande1 extends Model
{
    use HasFactory;

    // Spécifiez la table associée à ce modèle
    protected $table = 'commande1';

    // Indiquez les attributs qui sont mass-assignable
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'burger_id',
        'statut',
        'date_commande',
    ];


    public function burger()
{
    return $this->belongsTo(Burger::class);
}

}
