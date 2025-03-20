<?php

namespace Database\Seeders;

use App\Models\MntCliente;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MntClientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        MntCliente::create([
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'email' => 'juan@example.com',
            'direccion_envio' => 'Calle 123',
            'direccion_facturacion' => 'Avenida 456',
            'telefono' => '123456789',
        ]);

        MntCliente::create([
            'nombre' => 'María',
            'apellido' => 'Gómez',
            'email' => 'maria@example.com',
            'direccion_envio' => 'Calle 789',
            'direccion_facturacion' => 'Avenida 101',
            'telefono' => '987654321',
        ]);

    }
}
