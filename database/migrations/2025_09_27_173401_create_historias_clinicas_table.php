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
        Schema::create('historias_clinicas', function (Blueprint $table) {
            $table->id('id_historia');
            $table->unsignedBigInteger('paciente_id');
            $table->unsignedBigInteger('psicologo_id');
            $table->date('fecha_registro');
            $table->time('hora_registro');
            $table->text('motivo_consulta');
            $table->text('enfermedad_actual');
            $table->text('antecedentes')->nullable();
            $table->text('examen_mental')->nullable();
            $table->text('diagnostico')->nullable();
            $table->text('plan_manejo')->nullable();
            $table->text('evolucion')->nullable();
            $table->string('firma_digital')->nullable();
            $table->boolean('bloqueado')->default(false);
            $table->timestamps();

            $table->foreign('paciente_id')->references('id_paciente')->on('pacientes')->onDelete('cascade');
            $table->foreign('psicologo_id')->references('id_psicologo')->on('psicologos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historias_clinicas');
    }
};
