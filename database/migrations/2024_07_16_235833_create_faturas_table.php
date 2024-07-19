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
        Schema::create('faturas', function (Blueprint $table) {
            $table->id();
            $table->string('numero_fatura');
            $table->date('data_emissao');
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->decimal('valor_total', 10, 2);
            $table->decimal('impostos', 10, 2);
            $table->enum('estado', ['Paga', 'Não Paga']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faturas');
    }
};
