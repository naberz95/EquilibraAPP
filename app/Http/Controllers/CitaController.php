<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Paciente;
use App\Models\Psicologo;
use App\Models\Plan;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class CitaController extends Controller
{
    /**
     * Display a listing of the resource with calendar view.
     */
    public function index(Request $request)
    {
        
        if ($request->ajax() && $request->has('start') && $request->has('end')) {
            return $this->getCalendarEvents($request);
        }

        if ($request->ajax() && $request->has('fecha')) {
            return $this->getCitasDelDia($request->fecha);
        }

        if ($request->ajax()) {
            return view('citas.partials.calendar-content');
        }

        return view('citas.index');
    }

    /**
     * Get calendar events for FullCalendar (public method)
     */
    public function getCalendarEvents(Request $request)
    {
        $start = Carbon::parse($request->start);
        $end = Carbon::parse($request->end);

        $citas = Cita::with(['paciente', 'psicologo'])
            ->whereBetween('fecha_cita', [$start->format('Y-m-d'), $end->format('Y-m-d')])
            ->get();

        $events = [];
        foreach ($citas as $cita) {
            $events[] = [
                'id' => $cita->id_cita,
                'title' => $cita->paciente->nombre . ' ' . $cita->paciente->apellido,
                'start' => $cita->fecha_cita->format('Y-m-d') . 'T' . Carbon::parse($cita->hora_cita)->format('H:i:s'),
                'end' => $cita->fecha_cita->format('Y-m-d') . 'T' . $this->calcularHoraFin($cita->hora_cita),
                'backgroundColor' => $this->getColorByEstado($cita->estado),
                'borderColor' => $this->getColorByEstado($cita->estado),
                'extendedProps' => [
                    'paciente' => $cita->paciente->nombre . ' ' . $cita->paciente->apellido,
                    'psicologo' => $cita->psicologo->nombre ?? 'Sin asignar',
                    'estado' => $cita->estado,
                    'observaciones' => $cita->observaciones
                ]
            ];
        }

        return response()->json($events);
    }

    /**
     * Get citas for a specific day
     */
    private function getCitasDelDia($fecha)
    {
        $citas = Cita::with(['paciente', 'psicologo', 'plan'])
            ->whereDate('fecha_cita', $fecha)
            ->orderBy('hora_cita')
            ->get();

        $horariosDisponibles = $this->getHorariosDisponibles($fecha, $citas);

        return view('citas.partials.day-schedule', compact('citas', 'fecha', 'horariosDisponibles'));
    }

    /**
     * Generate available time slots (7:00 AM to 6:00 PM, 45 min each)
     */
    private function getHorariosDisponibles($fecha, $citasDelDia = null)
    {
        $horarios = [];
        $horaInicio = Carbon::createFromTime(7, 0); 
        $horaFin = Carbon::createFromTime(18, 0); 

        if ($citasDelDia === null) {
            $citasDelDia = Cita::whereDate('fecha_cita', $fecha)->get();
        }

        $horariosOcupados = [];
        foreach ($citasDelDia as $cita) {
            $horariosOcupados[] = Carbon::parse($cita->hora_cita)->format('H:i');
        }

        $horaActual = $horaInicio->copy();
        while ($horaActual->lt($horaFin)) {
            $horarioStr = $horaActual->format('H:i');
            $horaFinSlot = $horaActual->copy()->addMinutes(45);
            
            $horarios[] = [
                'hora' => $horarioStr,
                'hora_fin' => $horaFinSlot->format('H:i'),
                'disponible' => !in_array($horarioStr, $horariosOcupados),
                'label' => $horarioStr . ' - ' . $horaFinSlot->format('H:i')
            ];

            $horaActual->addMinutes(45);
        }

        return $horarios;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $pacientes = Paciente::orderBy('id_paciente', 'asc')->get();
        $psicologos = Psicologo::with('usuario')->get()->sortBy('usuario.nombre');
        $planes = Plan::orderBy('id_plan', 'asc')->get();
        
        $fechaSeleccionada = $request->get('fecha', now()->format('Y-m-d'));
        $horaSeleccionada = $request->get('hora');
        
        $horariosDisponibles = $this->getHorariosDisponibles($fechaSeleccionada);

        if ($request->ajax()) {
            return view('citas.partials.create-content', compact(
                'pacientes', 'psicologos', 'planes', 'fechaSeleccionada', 
                'horaSeleccionada', 'horariosDisponibles'
            ));
        }

        return view('citas.create', compact(
            'pacientes', 'psicologos', 'planes', 'fechaSeleccionada', 
            'horaSeleccionada', 'horariosDisponibles'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        Log::info('Store cita request data:', $request->all());
        
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id_paciente',
            'psicologo_id' => 'required|exists:psicologos,id_psicologo',
            'plan_id' => 'required|exists:planes,id_plan',
            'fecha_cita' => 'required|date|after_or_equal:today',
            'hora_cita' => 'required|date_format:H:i',
            'estado' => 'required|in:programada,confirmada,en_proceso,completada,cancelada',
            'observaciones' => 'nullable|string|max:1000',
            
        ]);

        $citaExistente = Cita::where('fecha_cita', $request->fecha_cita)
            ->where('hora_cita', $request->hora_cita)
            ->first();

        if ($citaExistente) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'El horario seleccionado no está disponible'
                ], 422);
            }
            return back()->withErrors(['hora_cita' => 'El horario seleccionado no está disponible']);
        }

        $plan = Plan::findOrFail($request->plan_id);
        $costoFinal = $plan->costo_consulta_base;

        $cita = Cita::create([
            'paciente_id' => $request->paciente_id,
            'psicologo_id' => $request->psicologo_id,
            'plan_id' => $request->plan_id,
            'fecha_cita' => $request->fecha_cita,
            'hora_cita' => $request->hora_cita,
            'estado' => $request->estado,
            'observaciones' => $request->observaciones ?? '',
            'costo_final' => $costoFinal,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Cita creada exitosamente',
                'cita' => $cita->load(['paciente', 'psicologo', 'plan'])
            ]);
        }

        return redirect()->route('citas.index')
                        ->with('success', 'Cita creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $cita = Cita::with(['paciente', 'psicologo', 'plan'])->findOrFail($id);

        if ($request->ajax()) {
            return view('citas.partials.show-content', compact('cita'));
        }

        return view('citas.show', compact('cita'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $cita = Cita::findOrFail($id);
        $pacientes = Paciente::orderBy('id_paciente', 'asc')->get();
        $psicologos = Psicologo::with('usuario')->get()->sortBy('usuario.nombre');
        $planes = Plan::orderBy('id_plan', 'asc')->get();
        
        $horariosDisponibles = $this->getHorariosDisponibles($cita->fecha_cita->format('Y-m-d'));

        if ($request->ajax()) {
            return view('citas.partials.edit-content', compact(
                'cita', 'pacientes', 'psicologos', 'planes', 'horariosDisponibles'
            ));
        }

        return view('citas.edit', compact(
            'cita', 'pacientes', 'psicologos', 'planes', 'horariosDisponibles'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $cita = Cita::findOrFail($id);

        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id_paciente',
            'psicologo_id' => 'required|exists:psicologos,id_psicologo',
            'plan_id' => 'required|exists:planes,id_plan',
            'fecha_cita' => 'required|date',
            'hora_cita' => 'required|date_format:H:i',
            'estado' => 'required|in:programada,confirmada,en_proceso,completada,cancelada',
            'observaciones' => 'nullable|string|max:1000',
            
        ]);

        $citaExistente = Cita::where('fecha_cita', $request->fecha_cita)
            ->where('hora_cita', $request->hora_cita)
            ->where('id_cita', '!=', $cita->id_cita)
            ->first();

        if ($citaExistente) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'El horario seleccionado no está disponible'
                ], 422);
            }
            return back()->withErrors(['hora_cita' => 'El horario seleccionado no está disponible']);
        }

        $plan = Plan::findOrFail($request->plan_id);
        $costoFinal = $plan->costo_consulta_base;

        $cita->update([
            'paciente_id' => $request->paciente_id,
            'psicologo_id' => $request->psicologo_id,
            'plan_id' => $request->plan_id,
            'fecha_cita' => $request->fecha_cita,
            'hora_cita' => $request->hora_cita,
            'estado' => $request->estado,
            'observaciones' => $request->observaciones ?? '',
            'costo_final' => $costoFinal,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Cita actualizada exitosamente',
                'cita' => $cita->load(['paciente', 'psicologo', 'plan'])
            ]);
        }

        return redirect()->route('citas.index')
                        ->with('success', 'Cita actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $cita = Cita::findOrFail($id);
        $cita->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Cita eliminada exitosamente'
            ]);
        }

        return redirect()->route('citas.index')
                        ->with('success', 'Cita eliminada exitosamente');
    }

    /**
     * Calculate end time (45 minutes later)
     */
    private function calcularHoraFin($horaInicio)
    {
        return Carbon::parse($horaInicio)->addMinutes(45)->format('H:i:s');
    }

    /**
     * Get color by appointment status
     */
    private function getColorByEstado($estado)
    {
        $colores = [
            'programada' => '#007bff',   
            'confirmada' => '#28a745',   
            'en_proceso' => '#ffc107',   
            'completada' => '#6f42c1',   
            'cancelada' => '#dc3545',    
        ];

        return $colores[$estado] ?? '#6c757d'; 
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'id_cita';
    }
}