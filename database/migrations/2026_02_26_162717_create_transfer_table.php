<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();

            // Relaciona com a transação genérica
            $table->foreignId('transaction_id')
                  ->constrained('transactions')
                  ->onDelete('cascade');

            // Usuário remetente
            $table->foreignId('sender_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Usuário destinatário
            $table->foreignId('receiver_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // Valor da transferência
            $table->decimal('amount', 10, 2);

            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
