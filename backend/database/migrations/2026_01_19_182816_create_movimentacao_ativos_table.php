<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movimentacao_ativos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ativo_id')->constrained('ativos');
            $table->foreignId('colaborador_id')->constrained('colaboradores');
            $table->string('tipo');
            $table->text('motivo');
            $table->string('realizado_por');
            $table->timestamp('data_hora');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimentacao_ativos');
    }
};
