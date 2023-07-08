<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::factory('20', ['onService' => 'null'])->create();

        for ($i=0; $i < 10; $i++) { 
            $service = Service::inRandomOrder()->first();

            Service::factory('1', ['onService' => $service->name])->create();
        }

    }
}
