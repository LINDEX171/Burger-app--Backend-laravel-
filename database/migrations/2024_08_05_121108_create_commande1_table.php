<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('commande1', function (Blueprint $table) {
            $table->id();
            $table->string('nom'); // Ajout de la colonne nom
            $table->string('prenom'); // Ajout de la colonne prenom
            $table->string('email'); // Ajout de la colonne prenom
            $table->foreignId('burger_id')->constrained('burgers')->onDelete('cascade'); // Référence au burger
            $table->enum('statut', ['en_attente', 'terminee', 'annulee', 'payee'])->default('en_attente'); // Ajout de la colonne statut
            $table->dateTime('date_commande'); // Ajout de la colonne date_commande
            $table->timestamps(); // Ajout des colonnes created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commande1');
    }
};
