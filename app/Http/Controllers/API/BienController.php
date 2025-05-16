<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Bien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BienController extends Controller
{
    /**
     * Mostrar todos los bienes
     */
    public function index()
    {
        $bienes = Bien::with(['categoria', 'ubicacion'])->get();
        return response()->json([
            'success' => true,
            'data' => $bienes,
        ]);
    }

    /**
     * Almacenar un nuevo bien
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'codigo_identificacion' => 'required|string|max:50|unique:bienes',
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'id_categoria' => 'nullable|exists:categorias,id_categoria',
            'marca' => 'nullable|string|max:100',
            'modelo' => 'nullable|string|max:100',
            'numero_serie' => 'nullable|string|max:100',
            'fecha_adquisicion' => 'nullable|date',
            'proveedor' => 'nullable|string|max:150',
            'costo_adquisicion' => 'nullable|numeric|min:0',
            'id_ubicacion' => 'nullable|exists:ubicaciones,id_ubicacion',
            'estado' => 'nullable|in:Nuevo,Usado,En reparación,De baja,Obsoleto',
            'valor_actual' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], 422);
        }

        $bien = Bien::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Bien creado exitosamente',
            'data' => $bien,
        ], 201);
    }

    /**
     * Mostrar un bien específico
     */
    public function show($id)
    {
        $bien = Bien::with(['categoria', 'ubicacion'])->find($id);

        if (!$bien) {
            return response()->json([
                'success' => false,
                'message' => 'Bien no encontrado',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $bien,
        ]);
    }

    /**
     * Actualizar un bien específico
     */
    public function update(Request $request, $id)
    {
        $bien = Bien::find($id);

        if (!$bien) {
            return response()->json([
                'success' => false,
                'message' => 'Bien no encontrado',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'codigo_identificacion' => 'required|string|max:50|unique:bienes,codigo_identificacion,' . $id . ',id_bien',
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'id_categoria' => 'nullable|exists:categorias,id_categoria',
            'marca' => 'nullable|string|max:100',
            'modelo' => 'nullable|string|max:100',
            'numero_serie' => 'nullable|string|max:100',
            'fecha_adquisicion' => 'nullable|date',
            'proveedor' => 'nullable|string|max:150',
            'costo_adquisicion' => 'nullable|numeric|min:0',
            'id_ubicacion' => 'nullable|exists:ubicaciones,id_ubicacion',
            'estado' => 'nullable|in:Nuevo,Usado,En reparación,De baja,Obsoleto',
            'valor_actual' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], 422);
        }

        $bien->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Bien actualizado exitosamente',
            'data' => $bien,
        ]);
    }

    /**
     * Eliminar un bien específico
     */
    public function destroy($id)
    {
        $bien = Bien::find($id);

        if (!$bien) {
            return response()->json([
                'success' => false,
                'message' => 'Bien no encontrado',
            ], 404);
        }

        $bien->delete();

        return response()->json([
            'success' => true,
            'message' => 'Bien eliminado exitosamente',
        ]);
    }
    
    /**
     * Buscar bienes por diferentes criterios
     */
    public function search(Request $request)
    {
        $query = Bien::with(['categoria', 'ubicacion']);

        // Filtrar por código
        if ($request->has('codigo')) {
            $query->where('codigo_identificacion', 'like', '%' . $request->codigo . '%');
        }

        // Filtrar por nombre
        if ($request->has('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        // Filtrar por categoría
        if ($request->has('categoria')) {
            $query->where('id_categoria', $request->categoria);
        }

        // Filtrar por ubicación
        if ($request->has('ubicacion')) {
            $query->where('id_ubicacion', $request->ubicacion);
        }

        // Filtrar por estado
        if ($request->has('estado')) {
            $query->where('estado', $request->estado);
        }

        $bienes = $query->get();

        return response()->json([
            'success' => true,
            'data' => $bienes,
        ]);
    }
}