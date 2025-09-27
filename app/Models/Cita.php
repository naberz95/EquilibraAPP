<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $table = 'citas';
    protected $primaryKey = 'id_cita';
    
    protected $fillable = [
        'paciente_id',
        'psicologo_id',
        'plan_id',
        'fecha_cita',
        'hora_cita',
        'estado',
        'observaciones',
        'costo_final'
    ];

    protected $attributes = [
        'observaciones' => '',
        'estado' => 'programada'
    ];

    protected $casts = [
        'fecha_cita' => 'datetime',
        'hora_cita' => 'datetime:H:i',
        'costo_final' => 'decimal:2'
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id', 'id_paciente');
    }

    public function psicologo()
    {
        return $this->belongsTo(Psicologo::class, 'psicologo_id', 'id_psicologo');
    }

    public function plan()
    {
        return $this->belongsTo(\App\Models\Plan::class, 'plan_id', 'id_plan');
    }
}
