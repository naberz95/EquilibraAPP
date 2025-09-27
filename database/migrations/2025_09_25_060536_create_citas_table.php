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
        Schema::create('citas', function (Blueprint $table) {
            $table->id('id_cita');
            $table->unsignedBigInteger('paciente_id');
            $table->unsignedBigInteger('psicologo_id');
            $table->unsignedBigInteger('plan_id');
            $table->date('fecha_cita');
            $table->time('hora_cita');
            $table->string('estado');
            $table->text('observaciones');
            $table->decimal('costo_final', 10, 2);
            $table->timestamps();
            
            $table->foreign('paciente_id')->references('id_paciente')->on('pacientes');
            $table->foreign('psicologo_id')->references('id_psicologo')->on('psicologos');
            $table->foreign('plan_id')->references('id_plan')->on('planes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
