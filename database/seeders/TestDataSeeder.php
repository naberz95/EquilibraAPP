<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Paciente;

class TestDataSeeder extends Seeder
{
    public function run()
    {
        
        $pacientes = [
            [
                'nombre' => 'Juan Carlos',
                'apellido' => 'Pérez García',
                'cedula' => '10001001',
                'fecha_nacimiento' => '1990-05-15',
                'lugar_nacimiento' => 'Bogotá',
                'sexo' => 'M',
                'barrio_residencia' => 'Centro',
                'direccion' => 'Calle 123 #45-67',
                'telefono' => '3001234567',
                'email' => 'juan.perez@email.com',
                'acudiente_nombre' => 'Pedro Pérez',
                'acudiente_telefono' => '3109876543',
                'entidad_id' => 1,
                'fecha_registro' => '2025-09-25'
            ],
            [
                'nombre' => 'María Elena',
                'apellido' => 'González López',
                'cedula' => '10002002',
                'fecha_nacimiento' => '1985-08-22',
                'lugar_nacimiento' => 'Medellín',
                'sexo' => 'F',
                'barrio_residencia' => 'Laureles',
                'direccion' => 'Carrera 80 #30-25',
                'telefono' => '3002345678',
                'email' => 'maria.gonzalez@email.com',
                'acudiente_nombre' => 'Ana López',
                'acudiente_telefono' => '3109876544',
                'entidad_id' => 1,
                'fecha_registro' => '2025-09-24'
            ],
            [
                'nombre' => 'Carlos Eduardo',
                'apellido' => 'Rodríguez Silva',
                'cedula' => '10003003',
                'fecha_nacimiento' => '1992-12-10',
                'lugar_nacimiento' => 'Cali',
                'sexo' => 'M',
                'barrio_residencia' => 'San Antonio',
                'direccion' => 'Avenida 6 #12-34',
                'telefono' => '3003456789',
                'email' => 'carlos.rodriguez@email.com',
                'acudiente_nombre' => 'Eduardo Rodríguez',
                'acudiente_telefono' => '3109876545',
                'entidad_id' => 1,
                'fecha_registro' => '2025-09-23'
            ],
            [
                'nombre' => 'Ana Sofía',
                'apellido' => 'Martínez Torres',
                'cedula' => '10004004',
                'fecha_nacimiento' => '1988-03-18',
                'lugar_nacimiento' => 'Barranquilla',
                'sexo' => 'F',
                'barrio_residencia' => 'El Prado',
                'direccion' => 'Calle 72 #50-12',
                'telefono' => '3004567890',
                'email' => 'ana.martinez@email.com',
                'acudiente_nombre' => 'Sofía Torres',
                'acudiente_telefono' => '3109876546',
                'entidad_id' => 1,
                'fecha_registro' => '2025-09-22'
            ],
            [
                'nombre' => 'Luis Fernando',
                'apellido' => 'Hernández Ruiz',
                'cedula' => '10005005',
                'fecha_nacimiento' => '1995-07-03',
                'lugar_nacimiento' => 'Cartagena',
                'sexo' => 'M',
                'barrio_residencia' => 'Bocagrande',
                'direccion' => 'Carrera 1 #8-95',
                'telefono' => '3005678901',
                'email' => 'luis.hernandez@email.com',
                'acudiente_nombre' => 'Fernando Hernández',
                'acudiente_telefono' => '3109876547',
                'entidad_id' => 1,
                'fecha_registro' => '2025-09-21'
            ]
        ];

        foreach ($pacientes as $paciente) {
            Paciente::create($paciente);
        }

        echo "✅ Se crearon " . count($pacientes) . " pacientes de prueba\n";
    }
}