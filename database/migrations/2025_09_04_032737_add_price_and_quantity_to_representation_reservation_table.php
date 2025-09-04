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
        Schema::table('representation_reservation', function (Blueprint $table) {
            $table->foreignId('price_id')->nullable()->after('reservation_id')->constrained('prices')->onDelete('cascade');
            $table->integer('quantity')->default(1)->after('price_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('representation_reservation', function (Blueprint $table) {
            $table->dropForeign(['price_id']);
            $table->dropColumn(['price_id', 'quantity']);
        });
    }
};
