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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade'); // Pedido ao qual o item pertence
            $table->foreignId('raffle_id')->constrained('raffles')->onDelete('cascade'); // Rifa comprada
            $table->foreignId('raffle_quota_id')->constrained()->cascadeOnDelete(); // Relacionamento com raffle_quotas
            $table->integer('quota_amount'); // Quantidade de cotas compradas para esta rifa
            $table->decimal('unit_price', 10, 2); // Preço unitário da cota na hora da compra
            $table->decimal('total_price', 10, 2); // Total calculado para este item
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
