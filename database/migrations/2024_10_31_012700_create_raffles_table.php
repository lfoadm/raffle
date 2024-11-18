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
        Schema::create('raffles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['active', 'closed', 'inactive'])->default('active');
            $table->integer('quota_count'); // quantidade de cotas
            $table->integer('quota_balance');  // Quantidade de cotas disponíveis
            $table->integer('quota_sold')->default(0);     // Quantidade de cotas já vendidas
            $table->decimal('quota_price', 10, 2); // valor da cota antes (->storedAs('total_value / quota_count'))
            $table->decimal('total_value', 10, 2); // total da rifa
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raffles');
    }
};
