<?php

namespace Database\Factories\All;

use App\Models\All\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\All\Raffle>
 */
class RaffleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quotaCount = $this->faker->numberBetween(10, 100); // Número de cotas
        $quotaPrice = $this->faker->randomFloat(2, 5, 50); // Valor de cada cota
        $totalValue = $quotaCount * $quotaPrice; // Total da rifa
        $quotaSold = 0; // Total da rifa
        $quotaBalance = $quotaCount - $quotaSold; // Total da rifa

        return [
            'user_id' => User::factory(), // Cria ou relaciona com um usuário
            'category_id' => Category::factory(), // Cria ou relaciona com uma categoria
            'title' => $this->faker->sentence(3), // Gera um título fictício
            'slug' => $this->faker->unique()->slug(), // Slug único
            'description' => $this->faker->paragraph(), // Descrição fictícia
            'image' => $this->faker->imageUrl(640, 480, 'business', true, 'raffle'), // Gera uma URL fictícia de imagem
            'status' => $this->faker->randomElement(['active', 'closed', 'inactive']), // Escolhe um status aleatório
            'quota_count' => $quotaCount, // Define o número de cotas
            'quota_balance' => $quotaBalance, // Define o número de cotas
            'quota_sold' => $quotaSold, // Define o número de cotas
            'quota_price' => $quotaPrice, // Define o preço de cada cota
            'total_value' => $totalValue, // Calcula o valor total
        ];
    }
}
