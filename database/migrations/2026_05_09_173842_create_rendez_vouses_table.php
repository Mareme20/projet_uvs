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
        Schema::create('rendez_vouses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('medecin_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('type'); // consultation, prestation
            $table->string('prestation_type')->nullable(); // Analyse, Radio, etc. (si type = prestation)
            $table->dateTime('date_rv');
            $table->string('statut')->default('en_attente'); // en_attente, valide, annule, effectue
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rendez_vouses');
    }
};
