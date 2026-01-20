<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimentacao_ativos', function (Blueprint $table) {
            $table->id();
            // Vincula ao ativo. Se o ativo for deletado, apaga o histórico também.
            $table->foreignId('ativo_id')->constrained('ativos')->onDelete('cascade');
            
            // IMPORTANTE: Adicionado ->nullable() e ->onDelete('set null')
            // Isso permite que o campo fique vazio quando o item for devolvido ao estoque.
            $table->foreignId('colaborador_id')->nullable()->constrained('colaboradores')->onDelete('set null');
            
            $table->string('tipo'); // "Entrega" ou "Devolução"
            $table->text('motivo');
            $table->string('realizado_por'); // Nome do usuário logado que fez a ação
            $table->timestamp('data_hora');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimentacao_ativos');
    }
};