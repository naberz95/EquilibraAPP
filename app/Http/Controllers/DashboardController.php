<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Paciente;
use App\Models\Cita;
use App\Models\Psicologo;
use App\Models\Entidad;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        
        $stats = [
            'pacientes' => Paciente::count(),
            'citas_hoy' => Cita::whereDate('fecha_cita', Carbon::today())->count(),
            'facturacion' => Cita::where('estado', 'completada')->sum('costo_final'),
            'pendientes' => Cita::where('estado', 'programada')->count()
        ];

        $proximasCitas = Cita::with(['paciente', 'psicologo.usuario'])
            ->whereBetween('fecha_cita', [Carbon::today(), Carbon::today()->addDays(7)])
            ->where('estado', 'programada')
            ->orderBy('fecha_cita')
            ->orderBy('hora_cita')
            ->limit(10)
            ->get();

        return view('dashboard', compact('stats', 'proximasCitas'));
    }
}
