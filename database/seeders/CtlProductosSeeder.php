<?php

namespace Database\Seeders;

use App\Models\CtlCategoria;
use App\Models\CtlProductos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CtlProductosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Crear una instancia de Faker
        $faker = Faker::create();

        // Obtener todas las categorías existentes
        $categorias = CtlCategoria::all();

        // Insertar 20 productos de prueba
        for ($i = 0; $i < 20; $i++) {
            CtlProductos::create([
                'nombre' => $faker->unique()->word, // Genera una palabra única para el nombre
                'precio' => $faker->randomFloat(2, 10, 1000), // Genera un precio aleatorio entre 10 y 1000
                'image' => $faker->imageUrl(640, 480, 'products', true), // Genera una URL de imagen aleatoria
                'categoria_id' => $categorias->random()->id, // Asocia el producto a una categoría aleatoria
            ]);
        }
    }
}
