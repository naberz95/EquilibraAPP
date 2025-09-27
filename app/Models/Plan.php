<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'planes';
    protected $primaryKey = 'id_plan';
    
    protected $fillable = [
        'entidad_id',
        'nombre_plan',
        'costo_consulta_base',
        'observaciones'
    ];

    protected $casts = [
        'costo_consulta_base' => 'decimal:2'
    ];

    public function getNombreAttribute()
    {
        return $this->nombre_plan;
    }
    
    public function getCostoAttribute()
    {
        return $this->costo_consulta_base;
    }

    public function entidad()
    {
        return $this->belongsTo(Entidad::class, 'entidad_id', 'id_entidad');
    }

    public function citas()
    {
        return $this->hasMany(Cita::class, 'plan_id', 'id_plan');
    }
}