<?php

namespace App\Http\Controllers;

use App\Models\Column;
use App\Models\Table;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ColumnController extends Controller
{
    public function update(int $tableId, int $columnId, Request $request): JsonResponse
    {
        $data = $request->validate([
            "nombre" => "sometimes|string",
            "tipo_dato" => "sometimes|string",
            "es_pk" => "sometimes|boolean",
            "es_fk" => "sometimes|boolean",
            "es_null" => "sometimes|boolean",
            "valor_defecto" => "sometimes|string|nullable",
            "descripcion" => "sometimes|string",
        ]);

        /** @var User $user */
        $user = auth()->user();

        /** @var Table $table */
        $table = $user->tables()->find($tableId);
        if ($table === null) return response()->json(null, 404);

        /** @var Column $column */
        $column = $table->columns()->find($columnId);
        if ($column === null) return response()->json(null, 404);

        $column->update($data);

        return response()->json($column->fresh());
    }

    public function delete(int $tableId, int $columnId): Response|JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        /** @var Table $table */
        $table = $user->tables()->find($tableId);

        if ($table === null)
            return response()->json(["error" => "table not found"], 404);

        /** @var Column $column */
        $column = $table->columns()->find($columnId);

        if ($column === null)
            return response()->json(["error" => "column not found"], 404);

        $column->delete();

        return response()->noContent();
    }
}
