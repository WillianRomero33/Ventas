<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CtlCategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $data = ['Categoria 1', 'categoria 2'];
        foreach ($data as $d) {
            DB::table('ctl_categorias')->insert([
                'nombre' => $d,
            ]);
        }
    }
}
