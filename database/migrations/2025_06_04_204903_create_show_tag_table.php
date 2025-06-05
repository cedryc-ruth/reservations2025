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
    Schema::create('show_tag', function (Blueprint $table) {
        $table->id();
        $table->foreignId('show_id')->constrained('shows')->onUpdate('cascade')->onDelete('restrict');
        $table->foreignId('tag_id')->constrained('tags')->onUpdate('cascade')->onDelete('restrict');
        $table->timestamps();
        $table->unique(['show_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('show_tag');
    }
};
