<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artist_type', function (Blueprint $table) {
            // Clé primaire automatique
            $table->id();

            // Clés étrangères
            $table->foreignId('artist_id')->constrained('artists')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('type_id')->constrained('types')->onDelete('cascade')->onUpdate('cascade');

            // Optionnel : pour éviter les doublons
            $table->unique(['artist_id', 'type_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artist_type');
    }
};
