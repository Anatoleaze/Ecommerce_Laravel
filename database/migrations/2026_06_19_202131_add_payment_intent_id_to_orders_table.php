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
        Schema::table('orders', function (Blueprint $table) {
            // Ajoute la colonne de manière sécurisée après 'methode_paiement'
            $table->string('payment_intent_id')->nullable()->after('methode_paiement');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Permet de revenir en arrière proprement si besoin
            $table->dropColumn('payment_intent_id');
        });
    }
};