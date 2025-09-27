<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entidad extends Model
{
    protected $table = 'entidades';
    protected $primaryKey = 'id_entidad';
    
    protected $fillable = [
        'nombre_entidad',
        'tipo',
        'descripcion'
    ];

    public function pacientes()
    {
        return $this->hasMany(Paciente::class, 'entidad_id', 'id_entidad');
    }

    public function planes()
    {
        return $this->hasMany(Plan::class, 'entidad_id', 'id_entidad');
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'id_entidad';
    }
}