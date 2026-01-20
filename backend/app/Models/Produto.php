<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{

    protected $fillable = [
        'nome', 
        'marca', 
        'descricao'
    ];


    public function ativos()
    {
        return $this->hasMany(Ativo::class);
    }
}