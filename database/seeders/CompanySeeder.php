<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company; // Asegúrate de importar el modelo Company

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Inserta dos empresas en la tabla companies
        Company::create([
            'name' => 'Webcoding',
        ]);

        
    }
}
