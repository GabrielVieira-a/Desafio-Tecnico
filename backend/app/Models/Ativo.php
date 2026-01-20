<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ativo extends Model
{
    use HasFactory;

    protected $table = 'ativos';


    protected $fillable = [
        'nome',
        'tipo',
        'numero_serie',
        'produto_id',
        'colaborador_id'
    ];


    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }


    public function colaborador()
    {
        return $this->belongsTo(Colaborador::class);
    }
}