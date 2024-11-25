<?php

namespace Database\Seeders;

use App\Models\All\Category;
use App\Models\All\Raffle;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RaffleSeeder extends Seeder
{
    public function run()
    {
        $users = User::all(); // Obtém todos os usuários
        $categories = Category::all(); // Obtém todas as categorias
        
        if ($users->isEmpty() || $categories->isEmpty()) {
            $this->command->error('Por favor, crie usuários e categorias antes de rodar a seeder.');
            return;
        }

        // Cria 20 rifas
        for ($i = 1; $i <= 20; $i++) {
            $quotaCount = fake()->numberBetween(50, 500); // Número aleatório de cotas
            $quotaPrice = fake()->randomFloat(2, 10, 100); // Preço aleatório por cota
            $totalValue = $quotaCount * $quotaPrice;
            $quotaSold = 0; // Inicialmente nenhuma cota foi vendida
            $quotaBalance = $quotaCount - $quotaSold; // Saldo de cotas

            // Criação de Rifa e Cotação automaticamente
            Raffle::factory()
                ->create([
                    'user_id' => $users->random()->id, // Usuário aleatório
                    'category_id' => $categories->random()->id, // Categoria aleatória
                    'title' => fake()->sentence(3),
                    'slug' => Str::slug(fake()->sentence(3) . '-' . $i),
                    'description' => fake()->paragraph(),
                    'image' => fake()->imageUrl(640, 480, 'raffles', true), // URL de imagem falsa
                    'status' => fake()->randomElement(['active', 'closed', 'inactive']),
                    'quota_count' => $quotaCount,
                    'quota_balance' => $quotaBalance,
                    'quota_sold' => $quotaSold,
                    'quota_price' => $quotaPrice,
                    'total_value' => $totalValue,
                ]);

            // Após a criação da rifa, as cotas são criadas automaticamente pela factory de Raffle
        }

        $this->command->info('Rifas e cotas criadas com sucesso!');
    }
}
