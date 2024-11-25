<?php

namespace Database\Factories\All;

use App\Models\All\Raffle;
use App\Models\All\RaffleQuota;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\All\RaffleQuota>
 */
class RaffleQuotaFactory extends Factory
{
    protected $model = RaffleQuota::class;

    public function definition(): array
    {
        return [
            'raffle_id' => Raffle::factory(), // Relaciona a uma rifa
            'quota_number' => $this->faker->unique()->numberBetween(1, 1000), // Número único da cota
            'status' => $this->faker->randomElement(['available', 'reserved', 'sold']), // Status aleatório
        ];
    }
}
