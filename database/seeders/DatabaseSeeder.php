<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CreateRolesAndAdmin::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(StatusTableSeeder::class);
        $this->call(WorkerSeeder::class);

        
    }
}
