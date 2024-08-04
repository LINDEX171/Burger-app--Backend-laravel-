<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Burger extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'image', 'description', 'is_active'];

    // Relation avec Commande
    public function commandes()
    {
        return $this->hasMany(Commande::class, 'burger_id');
    }
}
