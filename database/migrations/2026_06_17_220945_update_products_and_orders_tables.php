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
        // 1. Modifier la table 'products' pour rendre 'sale_price' nullable
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('sale_price', 10, 2)->nullable()->change(); 
            // Note : Adapte les arguments (10, 2) selon ce que tu avais mis au départ dans ta table products
        });

        // 2. Modifier la table 'orders' pour changer la valeur par défaut du statut
        Schema::table('orders', function (Blueprint $table) {
            $table->string('statut')->default('payé')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // En cas de "rollback", on remet les états d'origine
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('sale_price', 10, 2)->nullable(false)->change();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->string('statut')->default('en attente')->change();
        });
    }
};