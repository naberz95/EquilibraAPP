<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entidad;
use Illuminate\Validation\Rule;

class EntidadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $entidades = Entidad::withCount('pacientes')->orderBy('id_entidad', 'asc')->get();

        if ($request->ajax()) {
            return view('entidades.partials.index-content', compact('entidades'));
        }
        
        return view('entidades.index', compact('entidades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        
        if ($request->ajax()) {
            return view('entidades.partials.create-content');
        }
        
        return view('entidades.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_entidad' => 'required|string|max:255|unique:entidades',
            'tipo' => 'required|string|max:100',
            'descripcion' => 'required|string|max:1000',
        ]);

        $entidad = Entidad::create([
            'nombre_entidad' => $request->nombre_entidad,
            'tipo' => $request->tipo,
            'descripcion' => $request->descripcion,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Entidad creada exitosamente',
                'entidad' => $entidad
            ]);
        }

        return redirect()->route('entidades.index')
                        ->with('success', 'Entidad creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $entidad = Entidad::with(['pacientes' => function($query) {
            $query->orderBy('id_paciente', 'asc')->limit(10);
        }])->findOrFail($id);

        if ($request->ajax()) {
            return view('entidades.partials.show-content', compact('entidad'));
        }
        
        return view('entidades.show', compact('entidad'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $entidad = Entidad::findOrFail($id);

        if ($request->ajax()) {
            return view('entidades.partials.edit-content', compact('entidad'));
        }
        
        return view('entidades.edit', compact('entidad'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $entidad = Entidad::findOrFail($id);
        
        $request->validate([
            'nombre_entidad' => [
                'required',
                'string',
                'max:255',
                Rule::unique('entidades')->ignore($entidad->id_entidad, 'id_entidad')
            ],
            'tipo' => 'required|string|max:100',
            'descripcion' => 'required|string|max:1000',
        ]);

        $entidad->update([
            'nombre_entidad' => $request->nombre_entidad,
            'tipo' => $request->tipo,
            'descripcion' => $request->descripcion,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Entidad actualizada exitosamente',
                'entidad' => $entidad
            ]);
        }

        return redirect()->route('entidades.index')
                        ->with('success', 'Entidad actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $entidad = Entidad::findOrFail($id);

        if ($entidad->pacientes()->count() > 0) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar la entidad porque tiene pacientes asociados'
                ], 400);
            }
            
            return redirect()->route('entidades.index')
                            ->with('error', 'No se puede eliminar la entidad porque tiene pacientes asociados');
        }

        $nombre = $entidad->nombre_entidad;
        $entidad->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Entidad '{$nombre}' eliminada exitosamente"
            ]);
        }

        return redirect()->route('entidades.index')
                        ->with('success', "Entidad '{$nombre}' eliminada exitosamente");
    }
}