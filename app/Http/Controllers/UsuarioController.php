<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Role;
use App\Models\Psicologo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $usuarios = Usuario::with('role')->orderBy('id_usuario', 'asc')->get();

        if ($request->ajax()) {
            return view('usuarios.partials.index-content', compact('usuarios'));
        }
        
        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $roles = Role::all();

        if ($request->ajax()) {
            return view('usuarios.partials.create-content', compact('roles'));
        }
        
        return view('usuarios.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $rules = [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuarios',
            'contraseña' => 'required|string|min:6|confirmed',
            'rol_id' => 'required|exists:roles,id_rol',
            'estado' => 'required|in:activo,inactivo'
        ];

        $role = Role::find($request->rol_id);
        $isPsicologo = $role && $role->nombre_rol === 'Psicologo';

        if ($isPsicologo) {
            $rules = array_merge($rules, [
                'cedula' => 'required|string|max:20|unique:psicologos,cedula',
                'tarjeta_profesional' => 'required|string|max:50|unique:psicologos,tarjeta_profesional',
                'especialidad' => 'required|string|max:255',
                'fecha_registro' => 'required|date',
                'firma_digital' => 'required|string|max:255'
            ]);
        }

        $request->validate($rules);

        $usuario = Usuario::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'contraseña' => Hash::make($request->contraseña),
            'rol_id' => $request->rol_id,
            'estado' => $request->estado,
        ]);

        if ($isPsicologo) {
            
            $firmaDigital = $request->firma_digital;
            if ($firmaDigital && strpos($firmaDigital, 'storage/firmas/firma_') !== false) {
                
                $archivoTemporal = basename($firmaDigital);
                $extension = pathinfo($archivoTemporal, PATHINFO_EXTENSION);
                $nuevoNombre = 'firma_' . $usuario->id_usuario . '_' . time() . '.' . $extension;

                $rutaTemporal = 'firmas/' . $archivoTemporal;
                $rutaNueva = 'firmas/' . $nuevoNombre;
                
                if (Storage::exists($rutaTemporal)) {
                    Storage::move($rutaTemporal, $rutaNueva);

                    $rutaPublicaTemporal = public_path('storage/firmas/' . $archivoTemporal);
                    $rutaPublicaNueva = public_path('storage/firmas/' . $nuevoNombre);
                    
                    if (file_exists($rutaPublicaTemporal)) {
                        rename($rutaPublicaTemporal, $rutaPublicaNueva);
                    }
                    
                    $firmaDigital = 'storage/firmas/' . $nuevoNombre;
                }
            }
            
            $usuario->psicologo()->create([
                'cedula' => $request->cedula,
                'tarjeta_profesional' => $request->tarjeta_profesional,
                'especialidad' => $request->especialidad,
                'fecha_registro' => $request->fecha_registro,
                'firma_digital' => $firmaDigital
            ]);
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true, 
                'message' => $isPsicologo ? 'Psicólogo creado exitosamente' : 'Usuario creado exitosamente'
            ]);
        }

        return redirect()->route('usuarios.index')->with('success', 
            $isPsicologo ? 'Psicólogo creado exitosamente.' : 'Usuario creado exitosamente.'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Usuario $usuario)
    {
        $usuario->load('role');
        return view('usuarios.show', compact('usuario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Usuario $usuario)
    {
        $roles = Role::all();
        $usuario->load('role', 'psicologo'); 
        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Usuario $usuario)
    {
        
        $rules = [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('usuarios', 'email')->ignore($usuario->id_usuario, 'id_usuario')],
            'contraseña' => 'nullable|string|min:6|confirmed',
            'rol_id' => 'required|exists:roles,id_rol',
            'estado' => 'required|in:activo,inactivo'
        ];

        $role = Role::find($request->rol_id);
        $isPsicologo = $role && $role->nombre_rol === 'Psicologo';

        if ($isPsicologo) {
            $rules = array_merge($rules, [
                'cedula' => ['required', 'string', 'max:20', Rule::unique('psicologos', 'cedula')->ignore($usuario->psicologo->id_psicologo ?? null, 'id_psicologo')],
                'tarjeta_profesional' => ['required', 'string', 'max:50', Rule::unique('psicologos', 'tarjeta_profesional')->ignore($usuario->psicologo->id_psicologo ?? null, 'id_psicologo')],
                'especialidad' => 'required|string|max:255',
                'fecha_registro' => 'required|date',
                'firma_digital' => 'nullable|string|max:255'
            ]);
        }

        $request->validate($rules);

        $data = [
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'rol_id' => $request->rol_id,
            'estado' => $request->estado,
        ];

        if ($request->filled('contraseña')) {
            $data['contraseña'] = Hash::make($request->contraseña);
        }

        $usuario->update($data);

        if ($isPsicologo) {
            
            $firmaDigital = $request->firma_digital;
            if ($firmaDigital && strpos($firmaDigital, 'storage/firmas/firma_') !== false && strpos($firmaDigital, '_temp_') !== false) {
                
                $archivoTemporal = basename($firmaDigital);
                $extension = pathinfo($archivoTemporal, PATHINFO_EXTENSION);
                $nuevoNombre = 'firma_' . $usuario->id_usuario . '_' . time() . '.' . $extension;

                $rutaTemporal = 'firmas/' . $archivoTemporal;
                $rutaNueva = 'firmas/' . $nuevoNombre;
                
                if (Storage::exists($rutaTemporal)) {
                    
                    if ($usuario->psicologo && $usuario->psicologo->firma_digital) {
                        $rutaAnterior = str_replace('storage/', '', $usuario->psicologo->firma_digital);
                        if (Storage::exists($rutaAnterior)) {
                            Storage::delete($rutaAnterior);
                        }

                        $rutaPublicaAnterior = public_path($usuario->psicologo->firma_digital);
                        if (file_exists($rutaPublicaAnterior)) {
                            unlink($rutaPublicaAnterior);
                        }
                    }
                    
                    Storage::move($rutaTemporal, $rutaNueva);

                    $rutaPublicaTemporal = public_path('storage/firmas/' . $archivoTemporal);
                    $rutaPublicaNueva = public_path('storage/firmas/' . $nuevoNombre);
                    
                    if (file_exists($rutaPublicaTemporal)) {
                        rename($rutaPublicaTemporal, $rutaPublicaNueva);
                    }
                    
                    $firmaDigital = 'storage/firmas/' . $nuevoNombre;
                }
            } else if (!$firmaDigital && $usuario->psicologo) {
                
                $firmaDigital = $usuario->psicologo->firma_digital;
            }

            $psicologoData = [
                'cedula' => $request->cedula,
                'tarjeta_profesional' => $request->tarjeta_profesional,
                'especialidad' => $request->especialidad,
                'fecha_registro' => $request->fecha_registro,
                'firma_digital' => $firmaDigital
            ];

            if ($usuario->psicologo) {
                $usuario->psicologo->update($psicologoData);
            } else {
                $usuario->psicologo()->create($psicologoData);
            }
        } else {
            
            if ($usuario->psicologo) {
                
                if ($usuario->psicologo->firma_digital) {
                    $rutaFirma = str_replace('storage/', '', $usuario->psicologo->firma_digital);
                    if (Storage::exists($rutaFirma)) {
                        Storage::delete($rutaFirma);
                    }
                    
                    $rutaPublicaFirma = public_path($usuario->psicologo->firma_digital);
                    if (file_exists($rutaPublicaFirma)) {
                        unlink($rutaPublicaFirma);
                    }
                }
                
                $usuario->psicologo->delete();
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true, 
                'message' => $isPsicologo ? 'Psicólogo actualizado exitosamente' : 'Usuario actualizado exitosamente'
            ]);
        }

        return redirect()->route('usuarios.index')->with('success', 
            $isPsicologo ? 'Psicólogo actualizado exitosamente.' : 'Usuario actualizado exitosamente.'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Usuario $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado exitosamente.');
    }

    /**
     * Toggle user status (only for AJAX requests)
     */
    public function toggleStatus(Request $request, Usuario $usuario)
    {
        $request->validate([
            'estado' => 'required|in:activo,inactivo'
        ]);

        $usuario->update(['estado' => $request->estado]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Estado actualizado exitosamente']);
        }

        return redirect()->back()->with('success', 'Estado del usuario actualizado exitosamente.');
    }
}
