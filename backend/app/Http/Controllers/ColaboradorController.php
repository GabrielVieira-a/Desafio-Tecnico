<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use Illuminate\Http\Request;

class ColaboradorController extends Controller
{

    public function store(Request $request)
    {

        $dadosValidados = $request->validate([
            'nome'  => 'required|string|max:255',
            'email' => 'required|email|unique:colaboradores,email',
        ]);


        $colaborador = Colaborador::create($dadosValidados);


        return response()->json([
            'message' => 'Colaborador cadastrado com sucesso!',
            'data' => $colaborador
        ], 201);
    }


    public function index()
    {
        return response()->json(Colaborador::all(), 200);
    }
}