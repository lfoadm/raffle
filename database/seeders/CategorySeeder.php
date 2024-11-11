<?php

namespace Database\Seeders;

use App\Models\All\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Ações solidárias', 'description' => 'Rifas beneficentes, ações entre amigos.'],
            ['name' => 'Eletrônicos', 'description' => 'Celulares, tablets e notebooks de última geração.'],
            ['name' => 'Automóveis', 'description' => 'Carros, motos e bicicletas para todos os gostos.'],
            ['name' => 'Viagens e Experiências', 'description' => 'Pacotes de viagens, resorts e passeios turísticos.'],
            ['name' => 'Eletrodomésticos', 'description' => 'Geladeiras, TVs e micro-ondas modernos.'],
            ['name' => 'Moda e Acessórios', 'description' => 'Roupas de marca, bolsas e joias exclusivas.'],
            ['name' => 'Esportes e Fitness', 'description' => 'Equipamentos de academia, bicicletas e tênis esportivos.'],
            ['name' => 'Beleza e Cuidados Pessoais', 'description' => 'Kits de maquiagem, tratamentos de spa e perfumes.'],
            ['name' => 'Gastronomia', 'description' => 'Cestas gourmet, vinhos e jantares em restaurantes.'],
            ['name' => 'Casa e Decoração', 'description' => 'Móveis, itens decorativos e acessórios para o lar.'],
            ['name' => 'Brinquedos e Jogos', 'description' => 'Consoles de videogame, brinquedos infantis e jogos de tabuleiro.'],
            ['name' => 'Computadores e Periféricos', 'description' => 'PCs, monitores e acessórios de informática.'],
            ['name' => 'Ferramentas e Equipamentos', 'description' => 'Ferramentas para casa e kits de jardinagem.'],
            ['name' => 'Animais e Pets', 'description' => 'Rações, acessórios e itens para cuidados com pets.'],
            ['name' => 'Cursos e Assinaturas', 'description' => 'Cursos online e assinaturas de plataformas de streaming.'],
            ['name' => 'Ingressos para Eventos', 'description' => 'Ingressos para shows, festivais e jogos esportivos.'],
            ['name' => 'Instrumentos Musicais', 'description' => 'Guitarras, teclados e fones de alta qualidade.'],
            ['name' => 'Saúde e Bem-estar', 'description' => 'Suplementos, massagens e equipamentos de relaxamento.'],
            ['name' => 'Veículos Náuticos', 'description' => 'Barcos, jet skis e experiências de navegação.'],
            ['name' => 'Colecionáveis e Antiguidades', 'description' => 'Itens colecionáveis, moedas antigas e memorabilia.'],
            ['name' => 'Tecnologia e Gadgets', 'description' => 'Dispositivos inteligentes, drones e câmeras fotográficas.'],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'description' => $category['description'],
                'slug' => Str::slug($category['name']),
            ]);
        }
    }
}
