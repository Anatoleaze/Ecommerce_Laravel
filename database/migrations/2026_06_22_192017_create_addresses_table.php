<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();

            // Lien utilisateur
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            // Identité (utile livraison)
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();

            // Adresse
            $table->string('street');
            $table->string('additional_address')->nullable(); // complément (appt, étage...)

            $table->string('postal_code');
            $table->string('city');

            // IMPORTANT pour logistique / shipping
            $table->string('country');

            // Optionnel mais très utile e-commerce
            $table->string('phone')->nullable();

            // Adresse par défaut
            $table->boolean('is_default')->default(false);

            $table->timestamps();

            // Index pour perf (checkout / shipping calc)
            $table->index(['user_id', 'is_default']);
            $table->index('country');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};