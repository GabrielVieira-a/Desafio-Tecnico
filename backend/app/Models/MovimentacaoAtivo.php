<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimentacaoAtivo extends Model
{

    protected $table = 'movimentacao_ativos';


    protected $fillable = [
        'ativo_id', 
        'colaborador_id', 
        'tipo', 
        'motivo', 
        'realizado_por', 
        'data_hora'
    ];


    public function ativo()
    {
        return $this->belongsTo(Ativo::class, 'ativo_id');
    }

    public function colaborador()
    {
        return $this->belongsTo(Colaborador::class, 'colaborador_id');
    }
}