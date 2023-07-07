<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::factory('20')
        ->hasAttached(
            Service::inRandomOrder()->limit(rand(0, 10))->get(),
            function(){
                return [
                    'quantity' => rand(1, 12), 
                    'price' => rand(1, 200), 
                ];
            })
        ->create();
    }
}
