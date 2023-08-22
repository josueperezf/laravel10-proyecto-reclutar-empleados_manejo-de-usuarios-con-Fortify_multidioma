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
        Schema::table('vacantes', function (Blueprint $table) {
            $table->string('titulo', 200);
            $table->foreignId('salario_id')->constrained()->onDelete('cascade'); // si elimino el salario tambien se eliminan las vacantes que utilicen el id de ese salario
            $table->foreignId('categoria_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // usuario que creo la vacante
            $table->string('empresa', 150);
            $table->date('ultimo_dia');
            $table->text('descripcion');
            $table->string('imagen', 250);
            $table->integer('publicado')->default(1); // es como un estatus, publicado 1 para mostrar, 0 para no mostrar la vacante laboral
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vacantes', function (Blueprint $table) {
            // primero eliminamos la clave foranea
            $table->dropForeign('vacantes_user_id_foreign');
            $table->dropForeign('vacantes_salario_id_foreign');
            $table->dropForeign('vacantes_categoria_id_foreign');
            // ahora eliminamos las columnas
            $table->dropColumn([
                'categoria_id',
                'descripcion',
                'empresa',
                'imagen',
                'publicado',
                'salario_id',
                'titulo',
                'ultimo_dia',
                'user_id',
            ]);
        });
    }
};
