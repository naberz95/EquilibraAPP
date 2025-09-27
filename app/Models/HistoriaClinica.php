<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriaClinica extends Model
{
    protected $table = 'historias_clinicas';
    protected $primaryKey = 'id_historia';
    
    protected $fillable = [
        'paciente_id',
        'psicologo_id',
        'fecha_registro',
        'hora_registro',
        'motivo_consulta',
        'enfermedad_actual',
        'antecedentes',
        'examen_mental',
        'diagnostico',
        'plan_manejo',
        'evolucion',
        'firma_digital',
        'bloqueado'
    ];

    protected $casts = [
        'fecha_registro' => 'date',
        'hora_registro' => 'datetime:H:i',
        'bloqueado' => 'boolean'
    ];

    protected $attributes = [
        'bloqueado' => false
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id', 'id_paciente');
    }

    public function psicologo()
    {
        return $this->belongsTo(Psicologo::class, 'psicologo_id', 'id_psicologo');
    }

    public function getFirmaUrlAttribute()
    {
        if (!$this->firma_digital) return null;
        return asset($this->firma_digital);
    }
}
