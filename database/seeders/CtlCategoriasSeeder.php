<?php

namespace Database\Seeders;

use App\Models\CtlCategoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CtlCategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $faker = Faker::create();

        // Insertar 10 categorías de prueba
        for ($i = 0; $i < 10; $i++) {
            CtlCategoria::create([
                'nombre' => $faker->unique()->word, // Genera una palabra única para el nombre
            ]);
        }
    }
}
