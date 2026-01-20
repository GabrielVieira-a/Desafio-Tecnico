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
        Schema::create('ativos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('tipo'); // Campo necessário conforme seu AtivoController
            $table->string('numero_serie')->unique();
            
            // Relacionamento com Produtos (Obrigatório por requisito)
            $table->foreignId('produto_id')
                  ->constrained('produtos')
                  ->onDelete('cascade');

            // Relacionamento com Colaboradores (Permite ser nulo se estiver no estoque)
            $table->foreignId('colaborador_id')
                  ->nullable() 
                  ->constrained('colaboradores')
                  ->onDelete('set null'); 

            $table->string('status')->default('disponivel'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ativos');
    }
};