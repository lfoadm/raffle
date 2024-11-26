<?php

namespace Database\Factories\All;

use App\Models\All\Category;
use App\Models\All\Raffle;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\All\Raffle>
 */
class RaffleFactory extends Factory
{
    protected $model = Raffle::class;

    public function definition(): array
    {
        $quotaCount = $this->faker->numberBetween(10, 100); // Número de cotas
        $quotaPrice = $this->faker->randomFloat(2, 5, 50); // Valor de cada cota
        $totalValue = $quotaCount * $quotaPrice; // Total da rifa
        $quotaSold = 0; // Nenhuma cota vendida inicialmente
        $quotaBalance = $quotaCount - $quotaSold; // Saldo de cotas

        return [
            'user_id' => User::factory(), // Cria ou relaciona com um usuário
            'category_id' => Category::factory(), // Cria ou relaciona com uma categoria
            'title' => $this->faker->sentence(3), // Gera um título fictício
            'slug' => $this->faker->unique()->slug(), // Slug único
            'description' => $this->faker->paragraph(), // Descrição fictícia
            'image' => $this->faker->imageUrl(640, 480, 'business', true, 'raffle'), // URL fictícia de imagem
            'status' => $this->faker->randomElement(['active', 'closed', 'inactive']), // Status aleatório
            'quota_count' => $quotaCount, // Número de cotas
            //'quota_balance' => $quotaBalance, // Saldo de cotas
            //'quota_sold' => $quotaSold, // Nenhuma cota vendida
            'quota_price' => $quotaPrice, // Preço de cada cota
            //'total_value' => $totalValue, // Valor total
        ];
    }

    public function configure(): self
    {
        return $this->afterCreating(function (Raffle $raffle) {
            $quotaCount = $raffle->quota_count;

            // Cria as cotas para a rifa
            foreach (range(1, $quotaCount) as $quotaNumber) {
                $raffle->quotas()->create([
                    'quota_number' => $quotaNumber,
                    'status' => 'available', // Todas começam como disponíveis
                ]);
            }
        });
    }
    
}
