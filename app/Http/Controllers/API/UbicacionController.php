<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Ubicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UbicacionController extends Controller
{
    /**
     * Mostrar todas las ubicaciones
     */
    public function index()
    {
        $ubicaciones = Ubicacion::all();
        return response()->json([
            'success' => true,
            'data' => $ubicaciones,
        ]);
    }

    /**
     * Almacenar una nueva ubicación
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre_ubicacion' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'direccion' => 'nullable|string|max:255',
            'estado' => 'nullable|in:Activo,Inactivo',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], 422);
        }

        $ubicacion = Ubicacion::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Ubicación creada exitosamente',
            'data' => $ubicacion,
        ], 201);
    }

    /**
     * Mostrar una ubicación específica
     */
    public function show($id)
    {
        $ubicacion = Ubicacion::find($id);

        if (!$ubicacion) {
            return response()->json([
                'success' => false,
                'message' => 'Ubicación no encontrada',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $ubicacion,
        ]);
    }

    /**
     * Actualizar una ubicación específica
     */
    public function update(Request $request, $id)
    {
        $ubicacion = Ubicacion::find($id);

        if (!$ubicacion) {
            return response()->json([
                'success' => false,
                'message' => 'Ubicación no encontrada',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre_ubicacion' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'direccion' => 'nullable|string|max:255',
            'estado' => 'nullable|in:Activo,Inactivo',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], 422);
        }

        $ubicacion->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Ubicación actualizada exitosamente',
            'data' => $ubicacion,
        ]);
    }

    /**
     * Eliminar una ubicación específica
     */
    public function destroy($id)
    {
        $ubicacion = Ubicacion::find($id);

        if (!$ubicacion) {
            return response()->json([
                'success' => false,
                'message' => 'Ubicación no encontrada',
            ], 404);
        }

        // Verificar si hay bienes asociados a esta ubicación
        if ($ubicacion->bienes()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar la ubicación porque tiene bienes asociados',
            ], 409);
        }

        $ubicacion->delete();

        return response()->json([
            'success' => true,
            'message' => 'Ubicación eliminada exitosamente',
        ]);
    }
}
