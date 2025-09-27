<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Psicologo extends Model
{
    protected $table = 'psicologos';
    protected $primaryKey = 'id_psicologo';
    
    protected $fillable = [
        'usuario_id',
        'cedula',
        'tarjeta_profesional',
        'especialidad',
        'fecha_registro',
        'firma_digital'
    ];

    protected $casts = [
        'fecha_registro' => 'date'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id_usuario');
    }

    public function citas()
    {
        return $this->hasMany(Cita::class, 'psicologo_id', 'id_psicologo');
    }

    public function getNombreAttribute()
    {
        return $this->usuario->nombre ?? null;
    }
    
    public function getApellidoAttribute()
    {
        return $this->usuario->apellido ?? null;
    }
}
