<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{

    public function index()
    {
        try {
            return response()->json(Produto::all(), 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao listar produtos'], 500);
        }
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'descricao' => 'nullable|string'
        ]);

        try {
            $produto = Produto::create($validated);
            return response()->json($produto, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao cadastrar produto'], 500);
        }
    }


    public function destroy($id)
    {
        $produto = Produto::find($id);
        if (!$produto) {
            return response()->json(['error' => 'Produto não encontrado'], 404);
        }
        
        $produto->delete();
        return response()->json(['message' => 'Produto excluído com sucesso'], 200);
    }
}