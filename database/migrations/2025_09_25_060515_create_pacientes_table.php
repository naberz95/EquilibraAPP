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
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id('id_paciente');
            $table->string('nombre');
            $table->string('apellido');
            $table->string('cedula')->unique();
            $table->date('fecha_nacimiento');
            $table->string('lugar_nacimiento');
            $table->string('sexo');
            $table->string('barrio_residencia');
            $table->string('direccion');
            $table->string('telefono');
            $table->string('email');
            $table->string('acudiente_nombre');
            $table->string('acudiente_telefono');
            $table->unsignedBigInteger('entidad_id');
            $table->date('fecha_registro');
            $table->timestamps();
            
            $table->foreign('entidad_id')->references('id_entidad')->on('entidades');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
