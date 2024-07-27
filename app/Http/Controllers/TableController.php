<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index(): JsonResponse
    {
        /* TODO: Handle pagination */
        $tables = auth()->user()->tables;
        return response()->json($tables);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required'
        ]);

        /** @var User $user */
        $user = auth()->user();

        $table = $user->tables()->create($data);

        return response()->json($table, 201);
    }

    public function update(int $tableId, Request $request): JsonResponse
    {
        $data = $request->validate([
            "nombre" => "sometimes|string",
            "descripcion" => "sometimes|string",
        ]);

        /** @var User $user */
        $user = auth()->user();

        /** @var Table $table */
        $table = $user->tables()->find($tableId);

        if ($table == null)
            return response()->json(null, 404);

        $table->update($data);

        return response()->json($table->fresh());
    }

    public function getColumns(int $tableId): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        /** @var Table | null $table */
        $table = $user->tables()->find($tableId);

        if ($table === null) {
            return response()->json(null, 404);
        }

        $columns = $table->columns()->get();

        return response()->json($columns);
    }

    public function getColumn(int $tableId, int $columnId): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        /** @var Table $table */
        $table = $user->tables()->find($tableId);
        if ($table === null) return response()->json(null, 404);

        $column = $table->columns()->find($columnId);
        if ($column === null) return response()->json(null, 404);

        return response()->json($column);
    }

    public function addColumn(int $tableId, Request $request): JsonResponse
    {
        $data = $request->validate([
            "nombre" => "required",
            "tipo_dato" => "required",
            "es_pk" => "sometimes",
            "es_fk" => "sometimes",
            "es_null" => "sometimes",
            "valor_defecto" => "sometimes",
            "descripcion" => "required",
        ]);

        /** @var User $user */
        $user = auth()->user();

        /** @var Table $table */
        $table = $user->tables()->find($tableId);

        if ($table === null) {
            return response()->json(null, 404);
        }

        $column = $table->columns()->create($data);

        return response()->json($column, 201);
    }
}
