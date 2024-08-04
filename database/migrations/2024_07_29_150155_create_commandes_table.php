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
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade'); // Référence au client
            $table->foreignId('burger_id')->constrained('burgers')->onDelete('cascade'); // Référence au burger
            $table->enum('statut', ['en_attente', 'terminee', 'annulee', 'payee'])->default('en_attente'); // Statut de la commande
            $table->decimal('montant_total', 8, 2); // Montant total de la commande
            $table->dateTime('date_commande'); // Date de la commande
            $table->timestamps(); // Horodatage pour la création et la mise à jour
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
