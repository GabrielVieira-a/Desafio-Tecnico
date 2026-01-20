<?php

namespace App\Http\Controllers;

use App\Models\MovimentacaoAtivo;
use App\Models\Ativo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MovimentacaoAtivoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'ativo_id' => 'required|exists:ativos,id',
            'colaborador_id' => 'nullable|exists:colaboradores,id',
            'motivo' => 'nullable|string'
        ]);

        // Localiza o ativo e atualiza o dono na tabela principal
        $ativo = Ativo::findOrFail($request->ativo_id);
        $ativo->colaborador_id = $request->colaborador_id;
        $ativo->save();

        // Define o tipo de movimentação
        $tipo = $request->colaborador_id ? 'Entrega' : 'Devolução';

        // Registra no Histórico usando os campos da sua migration
        $movimentacao = MovimentacaoAtivo::create([
            'ativo_id' => $request->ativo_id,
            'colaborador_id' => $request->colaborador_id,
            'tipo' => $tipo,
            'motivo' => $request->motivo ?? "Movimentação de $tipo realizada via sistema.",
            'realizado_por' => Auth::user()->name, 
            'data_hora' => Carbon::now(),
        ]);

        return response()->json([
            'message' => 'Histórico registrado com sucesso!',
            'dados' => $movimentacao
        ]);
    }

    public function index()
    {
        // Retorna o histórico completo com nomes do Ativo e Colaborador
        return MovimentacaoAtivo::with(['ativo', 'colaborador'])
            ->orderBy('data_hora', 'desc')
            ->get();
    }
}