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
        Schema::create('raffle_quotas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('raffle_id')->constrained()->cascadeOnDelete();
            $table->integer('quota_number'); // Número da cota
            $table->enum('status', ['available', 'reserved', 'sold'])->default('available');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // Comprador, se vendido
            $table->unique(['raffle_id', 'quota_number']); // Garante que cada número é único por rifa
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('raffle_quotas');
    }
};
