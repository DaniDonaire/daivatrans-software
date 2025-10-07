<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Worker;

class WorkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = [
            [
                'name' => 'Trabajador1',
                'surname' => 'Apellido1',
                'dni' => '12345678A',
                'telefono' => '1234567890',
                'email' => 'trabajador1@example.com',
                'seguridad_social' => 'SS123456',
                'cuenta_bancaria' => 'ES7620770024003102575766',
                'observaciones' => 'Observaciones del trabajador 1',
            ],
            [
                'name' => 'Trabajador2',
                'surname' => 'Apellido2',
                'dni' => '87654321B',
                'telefono' => '0987654321',
                'email' => 'trabajador2@example.com',
                'seguridad_social' => 'SS654321',
                'cuenta_bancaria' => 'ES7620770024003102575767',
                'observaciones' => null,
            ],
        ];

        foreach($rows as $row) {
            Worker::create($row);
        }
    }
}
