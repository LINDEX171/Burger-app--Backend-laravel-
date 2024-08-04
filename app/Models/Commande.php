<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'burger_id',
        'statut',
        'montant_total',
        'date_commande',
    ];

    // Relation avec Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    // Relation avec Burger
    public function burger()
    {
        return $this->belongsTo(Burger::class, 'burger_id');
    }
}
