<?php

namespace App\Http\Controllers;

use App\Models\Ativo;
use Illuminate\Http\Request;

class AtivoController extends Controller
{

    public function index()
    {
        try {
            $ativos = Ativo::all();
            return response()->json($ativos, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao listar ativos.'], 500);
        }
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'tipo' => 'required|string|max:255',
            'numero_serie' => 'required|string|unique:ativos,numero_serie',
            'produto_id' => 'required|exists:produtos,id',
            'colaborador_id' => 'nullable|exists:colaboradores,id',
        ]);

        try {
            $ativo = Ativo::create($validated);
            return response()->json($ativo, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao salvar o ativo.'], 500);
        }
    }


    public function destroy($id)
    {
        try {
            $ativo = Ativo::find($id);
            if (!$ativo) {
                return response()->json(['error' => 'Ativo não encontrado'], 404);
            }

            $ativo->delete();
            return response()->json(['message' => 'Ativo excluído com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao excluir ativo.'], 500);
        }
    }
}