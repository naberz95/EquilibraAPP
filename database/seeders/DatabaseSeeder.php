<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        DB::table('roles')->insertOrIgnore([
            ['id_rol' => 1, 'nombre_rol' => 'admin', 'created_at' => now(), 'updated_at' => now()],
            ['id_rol' => 2, 'nombre_rol' => 'secretaria', 'created_at' => now(), 'updated_at' => now()],
            ['id_rol' => 3, 'nombre_rol' => 'psicologo', 'created_at' => now(), 'updated_at' => now()],
            ['id_rol' => 4, 'nombre_rol' => 'usuario', 'created_at' => now(), 'updated_at' => now()],
        ]);

    }
}
