<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistoriaClinica;
use App\Models\Paciente;
use App\Models\Psicologo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class HistoriaClinicaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $historias = HistoriaClinica::with(['paciente', 'psicologo.usuario'])
            ->orderBy('id_historia', 'desc')
            ->get();

        if ($request->ajax()) {
            return view('historias.partials.index-content', compact('historias'));
        }
        
        return view('historias.index', compact('historias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $pacientes = Paciente::orderBy('id_paciente', 'asc')->get();
        $psicologos = Psicologo::with('usuario')->get()->sortBy('usuario.nombre');

        if ($request->ajax()) {
            return view('historias.partials.create-content', compact('pacientes', 'psicologos'));
        }
        
        return view('historias.create', compact('pacientes', 'psicologos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id_paciente',
            'psicologo_id' => 'required|exists:psicologos,id_psicologo',
            'fecha_registro' => 'required|date',
            'hora_registro' => 'required|date_format:H:i',
            'motivo_consulta' => 'required|string|max:2000',
            'enfermedad_actual' => 'required|string|max:2000',
            'antecedentes' => 'nullable|string|max:2000',
            'examen_mental' => 'nullable|string|max:2000',
            'diagnostico' => 'nullable|string|max:1000',
            'plan_manejo' => 'nullable|string|max:2000',
            'evolucion' => 'nullable|string|max:2000',
            'firma_digital' => 'nullable|string|max:255'
        ]);

        if ($request->has('firma_digital')) {
            $firmaValue = trim($request->firma_digital);
            if ($firmaValue === '' || $firmaValue === '?' || $firmaValue === 'null') {
                $request->merge(['firma_digital' => null]);
            }
        }

        $firmaDigital = $request->firma_digital;

        if (empty($firmaDigital) || $firmaDigital === '?') {
            $firmaDigital = null;
        } else {

            $firmaDigital = $request->firma_digital;
        }

        $historia = HistoriaClinica::create([
            'paciente_id' => $request->paciente_id,
            'psicologo_id' => $request->psicologo_id,
            'fecha_registro' => $request->fecha_registro,
            'hora_registro' => $request->hora_registro,
            'motivo_consulta' => $request->motivo_consulta,
            'enfermedad_actual' => $request->enfermedad_actual,
            'antecedentes' => $request->antecedentes,
            'examen_mental' => $request->examen_mental,
            'diagnostico' => $request->diagnostico,
            'plan_manejo' => $request->plan_manejo,
            'evolucion' => $request->evolucion,
            'firma_digital' => $firmaDigital,
            'bloqueado' => false
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true, 
                'message' => 'Historia clínica creada exitosamente',
                'historia' => $historia->load(['paciente', 'psicologo.usuario'])
            ]);
        }

        return redirect()->route('historias.index')->with('success', 'Historia clínica creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $historia = HistoriaClinica::with(['paciente', 'psicologo.usuario'])->findOrFail($id);

        if ($request->ajax()) {
            return view('historias.partials.show-content', compact('historia'));
        }

        return view('historias.show', compact('historia'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $historia = HistoriaClinica::with(['paciente', 'psicologo.usuario'])->findOrFail($id);

        if ($historia->bloqueado) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Esta historia clínica está bloqueada y no puede ser editada'
                ], 403);
            }
            return redirect()->route('historias.index')->with('error', 'Esta historia clínica está bloqueada y no puede ser editada.');
        }
        
        $pacientes = Paciente::orderBy('id_paciente', 'asc')->get();
        $psicologos = Psicologo::with('usuario')->get()->sortBy('usuario.nombre');

        if ($request->ajax()) {
            return view('historias.partials.edit-content', compact('historia', 'pacientes', 'psicologos'));
        }

        return view('historias.edit', compact('historia', 'pacientes', 'psicologos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $historia = HistoriaClinica::findOrFail($id);

        if ($historia->bloqueado) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Esta historia clínica está bloqueada y no puede ser editada'
                ], 403);
            }
            return redirect()->route('historias.index')->with('error', 'Esta historia clínica está bloqueada y no puede ser editada.');
        }

        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id_paciente',
            'psicologo_id' => 'required|exists:psicologos,id_psicologo',
            'fecha_registro' => 'required|date',
            'hora_registro' => 'required|date_format:H:i',
            'motivo_consulta' => 'required|string|max:2000',
            'enfermedad_actual' => 'required|string|max:2000',
            'antecedentes' => 'nullable|string|max:2000',
            'examen_mental' => 'nullable|string|max:2000',
            'diagnostico' => 'nullable|string|max:1000',
            'plan_manejo' => 'nullable|string|max:2000',
            'evolucion' => 'nullable|string|max:2000',
            'firma_digital' => 'nullable|string|max:255'
        ]);

        $firmaDigital = $request->firma_digital;

        if (empty($firmaDigital) || $firmaDigital === '?') {
            $firmaDigital = $historia->firma_digital;
        } else {
            
            $firmaDigital = $request->firma_digital;
        }

        $historia->update([
            'paciente_id' => $request->paciente_id,
            'psicologo_id' => $request->psicologo_id,
            'fecha_registro' => $request->fecha_registro,
            'hora_registro' => $request->hora_registro,
            'motivo_consulta' => $request->motivo_consulta,
            'enfermedad_actual' => $request->enfermedad_actual,
            'antecedentes' => $request->antecedentes,
            'examen_mental' => $request->examen_mental,
            'diagnostico' => $request->diagnostico,
            'plan_manejo' => $request->plan_manejo,
            'evolucion' => $request->evolucion,
            'firma_digital' => $firmaDigital
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true, 
                'message' => 'Historia clínica actualizada exitosamente'
            ]);
        }

        return redirect()->route('historias.index')->with('success', 'Historia clínica actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $historia = HistoriaClinica::findOrFail($id);

        if ($historia->bloqueado) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Esta historia clínica está bloqueada y no puede ser eliminada'
                ], 403);
            }
            return redirect()->route('historias.index')->with('error', 'Esta historia clínica está bloqueada y no puede ser eliminada.');
        }

        if ($historia->firma_digital) {
            $rutaFirma = str_replace('storage/', '', $historia->firma_digital);
            if (Storage::exists($rutaFirma)) {
                Storage::delete($rutaFirma);
            }
            
            $rutaPublicaFirma = public_path($historia->firma_digital);
            if (file_exists($rutaPublicaFirma)) {
                unlink($rutaPublicaFirma);
            }
        }
        
        $historia->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Historia clínica eliminada exitosamente'
            ]);
        }

        return redirect()->route('historias.index')->with('success', 'Historia clínica eliminada exitosamente.');
    }

    /**
     * Toggle historia status (bloqueado/desbloqueado)
     */
    public function toggleBloqueo(Request $request, $id)
    {
        $historia = HistoriaClinica::findOrFail($id);
        
        $historia->update(['bloqueado' => !$historia->bloqueado]);
        
        $mensaje = $historia->bloqueado ? 'Historia clínica bloqueada' : 'Historia clínica desbloqueada';

        if ($request->ajax()) {
            return response()->json([
                'success' => true, 
                'message' => $mensaje,
                'bloqueado' => $historia->bloqueado
            ]);
        }

        return redirect()->back()->with('success', $mensaje);
    }
}
