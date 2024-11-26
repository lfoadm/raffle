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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained('carts')->onDelete('cascade'); // Carrinho ao qual o item pertence
            $table->foreignId('raffle_id')->constrained('raffles')->onDelete('cascade'); // Rifa adicionada ao carrinho
            $table->foreignId('raffle_quota_id')->constrained()->cascadeOnDelete(); // Relacionamento com raffle_quotas
            $table->decimal('unit_price', 10, 2); // Preço unitário da cota
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
