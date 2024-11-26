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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Usuário que fez o pedido
            $table->decimal('total_amount', 10, 2); // Valor total do pedido
            $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending');
            $table->string('payment_id')->nullable(); // ID do pagamento externo, caso utilize Mercado Pago
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
