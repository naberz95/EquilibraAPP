<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('usuarios')->where('rol_id', 2)->update(['rol_id' => 3]);

        DB::table('roles')->delete();

        DB::table('roles')->insert([
            [
                'id_rol' => 1,
                'nombre_rol' => 'Administrador',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_rol' => 2,
                'nombre_rol' => 'Secretaria',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_rol' => 3,
                'nombre_rol' => 'Psicologo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::statement('ALTER TABLE roles AUTO_INCREMENT = 4');

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
