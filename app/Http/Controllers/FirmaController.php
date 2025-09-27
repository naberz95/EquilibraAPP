<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FirmaController extends Controller
{
    /**
     * Guarda una firma dibujada en canvas como imagen
     */
    public function guardarFirmaDibujada(Request $request)
    {
        $request->validate([
            'firma_data' => 'required|string',
            'usuario_id' => 'required|integer'
        ]);

        try {
            
            $firmaData = $request->firma_data;

            $firmaData = preg_replace('#^data:image/\w+;base64,#i', '', $firmaData);

            $firmaDecoded = base64_decode($firmaData);
            
            if ($firmaDecoded === false) {
                return response()->json(['error' => 'Datos de firma inválidos'], 400);
            }

            $nombreArchivo = 'firma_' . $request->usuario_id . '_' . time() . '.png';
            $rutaArchivo = 'firmas/' . $nombreArchivo;

            Storage::put($rutaArchivo, $firmaDecoded);

            $rutaPublica = 'storage/firmas/' . $nombreArchivo;
            file_put_contents(public_path($rutaPublica), $firmaDecoded);
            
            return response()->json([
                'success' => true,
                'mensaje' => 'Firma guardada exitosamente',
                'ruta_archivo' => $rutaPublica,
                'nombre_archivo' => $nombreArchivo
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al guardar firma: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Guarda una firma subida como archivo
     */
    public function guardarFirmaSubida(Request $request)
    {
        $request->validate([
            'firma_archivo' => 'required|image|mimes:png,jpg,jpeg|max:2048',
            'usuario_id' => 'required|integer'
        ]);

        try {
            $archivo = $request->file('firma_archivo');

            $nombreArchivo = 'firma_' . $request->usuario_id . '_' . time() . '.' . $archivo->getClientOriginalExtension();

            $rutaArchivo = $archivo->storeAs('firmas', $nombreArchivo);

            $rutaPublica = 'storage/firmas/' . $nombreArchivo;
            $archivo->move(public_path('storage/firmas'), $nombreArchivo);
            
            return response()->json([
                'success' => true,
                'mensaje' => 'Firma subida exitosamente',
                'ruta_archivo' => $rutaPublica,
                'nombre_archivo' => $nombreArchivo
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al subir firma: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Elimina una firma
     */
    public function eliminarFirma(Request $request)
    {
        $request->validate([
            'nombre_archivo' => 'required|string'
        ]);

        try {
            $nombreArchivo = $request->nombre_archivo;

            Storage::delete('firmas/' . $nombreArchivo);

            $rutaPublica = public_path('storage/firmas/' . $nombreArchivo);
            if (file_exists($rutaPublica)) {
                unlink($rutaPublica);
            }
            
            return response()->json([
                'success' => true,
                'mensaje' => 'Firma eliminada exitosamente'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al eliminar firma: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Obtiene la firma de un usuario
     */
    public function obtenerFirma($userId)
    {
        try {
            
            $archivos = Storage::files('firmas');
            $firmaUsuario = null;
            
            foreach ($archivos as $archivo) {
                if (strpos($archivo, "firma_{$userId}_") !== false) {
                    $firmaUsuario = $archivo;
                    break;
                }
            }
            
            if (!$firmaUsuario) {
                return response()->json(['error' => 'Firma no encontrada'], 404);
            }
            
            $nombreArchivo = basename($firmaUsuario);
            $rutaPublica = 'storage/firmas/' . $nombreArchivo;
            
            return response()->json([
                'success' => true,
                'ruta_archivo' => $rutaPublica,
                'nombre_archivo' => $nombreArchivo
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al obtener firma: ' . $e->getMessage()
            ], 500);
        }
    }
}