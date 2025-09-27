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
        Schema::create('planes', function (Blueprint $table) {
            $table->id('id_plan');
            $table->unsignedBigInteger('entidad_id');
            $table->string('nombre_plan');
            $table->decimal('costo_consulta_base', 10, 2);
            $table->text('observaciones');
            $table->timestamps();
            
            $table->foreign('entidad_id')->references('id_entidad')->on('entidades');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planes');
    }
};
