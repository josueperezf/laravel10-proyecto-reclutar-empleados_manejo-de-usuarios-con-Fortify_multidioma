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
        Schema::create('candidatos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // si se elimina el usuario entonces que se eliminen tambien todas todas los candidatos para una vacante donde él aparezca como candidato
            $table->foreignId('vacante_id')->constrained()->onDelete('cascade'); // si se elimina la vacante, entonces que elimine tambien los candidatos que tenga la misma
            $table->string('cv', 100); // para guardar la ruta donde quedo guardado su curriculo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidatos');
    }
};
