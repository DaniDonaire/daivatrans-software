<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Status;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['name' => 'En proceso', 'color' => '#e2d5f8', 'text_color' => '#000000'],
            ['name' => 'Aprobado', 'color' => '#d4edda', 'text_color' => '#000000'],
            ['name' => 'Rechazado', 'color' => '#f6c5d1', 'text_color' => '#000000'],
            ['name' => 'Firmado', 'color' => '#df8fff', 'text_color' => '#000000'],

        ];

        // Insertar o actualizar los registros en la base de datos
        foreach ($statuses as $status) {
            Status::updateOrCreate(
                ['name' => $status['name']],
                [
                    'color' => $status['color'],
                    'text_color' => $status['text_color'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}