<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Leandro Oliveira',
            'email' => 'lfoadm@icloud.com',
            'mobile' => '34999749344',
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Usuario comum',
            'email' => 'user@user.com',
            'mobile' => '17997249344',
            'role' => 'user',
        ]);
    }
}
