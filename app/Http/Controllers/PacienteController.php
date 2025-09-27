<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Entidad;
use Illuminate\Validation\Rule;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pacientes = Paciente::with('entidad')->orderBy('id_paciente', 'asc')->get();

        if ($request->ajax()) {
            return view('pacientes.partials.index-content', compact('pacientes'));
        }
        
        return view('pacientes.index', compact('pacientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $entidades = Entidad::all();

        if ($request->ajax()) {
            return view('pacientes.partials.create-content', compact('entidades'));
        }
        
        return view('pacientes.create', compact('entidades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'cedula' => 'required|string|max:255|unique:pacientes',
            'fecha_nacimiento' => 'required|date',
            'lugar_nacimiento' => 'required|string|max:255',
            'sexo' => 'required|in:Masculino,Femenino,Otro',
            'barrio_residencia' => 'required|string|max:255',
            'direccion' => 'required|string|max:500',
            'telefono' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:pacientes',
            'acudiente_nombre' => 'nullable|string|max:255',
            'acudiente_telefono' => 'nullable|string|max:20',
            'entidad_id' => 'required|exists:entidades,id_entidad',
            'fecha_registro' => 'required|date'
        ]);

        Paciente::create($request->all());

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Paciente creado exitosamente']);
        }

        return redirect()->route('pacientes.index')->with('success', 'Paciente creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Paciente $paciente)
    {
        $paciente->load('entidad', 'citas');

        if ($request->ajax()) {
            return view('pacientes.partials.show-content', compact('paciente'));
        }
        
        return view('pacientes.show', compact('paciente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Paciente $paciente)
    {
        $entidades = Entidad::all();

        if ($request->ajax()) {
            return view('pacientes.partials.edit-content', compact('paciente', 'entidades'));
        }
        
        return view('pacientes.edit', compact('paciente', 'entidades'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Paciente $paciente)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'cedula' => ['required', 'string', 'max:255', Rule::unique('pacientes', 'cedula')->ignore($paciente->id_paciente, 'id_paciente')],
            'fecha_nacimiento' => 'required|date',
            'lugar_nacimiento' => 'required|string|max:255',
            'sexo' => 'required|in:Masculino,Femenino,Otro',
            'barrio_residencia' => 'required|string|max:255',
            'direccion' => 'required|string|max:500',
            'telefono' => 'required|string|max:20',
            'email' => ['required', 'email', 'max:255', Rule::unique('pacientes', 'email')->ignore($paciente->id_paciente, 'id_paciente')],
            'acudiente_nombre' => 'nullable|string|max:255',
            'acudiente_telefono' => 'nullable|string|max:20',
            'entidad_id' => 'required|exists:entidades,id_entidad',
            'fecha_registro' => 'required|date'
        ]);

        $paciente->update($request->all());

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Paciente actualizado exitosamente']);
        }

        return redirect()->route('pacientes.index')->with('success', 'Paciente actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paciente $paciente)
    {
        $paciente->delete();
        return response()->json(['success' => true, 'message' => 'Paciente eliminado exitosamente']);
    }
}
