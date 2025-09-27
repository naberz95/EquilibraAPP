<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $table = 'pacientes';
    protected $primaryKey = 'id_paciente';
    
    protected $fillable = [
        'nombre',
        'apellido',
        'cedula',
        'fecha_nacimiento',
        'lugar_nacimiento',
        'sexo',
        'barrio_residencia',
        'direccion',
        'telefono',
        'email',
        'acudiente_nombre',
        'acudiente_telefono',
        'entidad_id',
        'fecha_registro'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_registro' => 'date'
    ];

    public function entidad()
    {
        return $this->belongsTo(\App\Models\Entidad::class, 'entidad_id', 'id_entidad');
    }

    public function citas()
    {
        return $this->hasMany(Cita::class, 'paciente_id', 'id_paciente');
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'id_paciente';
    }
}
