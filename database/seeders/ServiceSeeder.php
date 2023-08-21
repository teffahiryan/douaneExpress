<?php

namespace Database\Seeders;

use App\Models\Group;
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

        Service::factory()->create([
            'reference' => 'DOU016',
            'name' => 'Impression document > 20 pages / page',
            'price' => 0.50,
            'image' => null,
            'group_id' => Group::find(1),
            'maxQuantity' => null
        ]);

        Service::factory()->create([
            'reference' => 'DOU015',
            'name' => 'Impression documents 11 à 20 pages',
            'price' => 5,
            'image' => null,
            'group_id' => Group::find(1),
            'maxQuantity' => 20.00
        ]);

        Service::factory()->create([
            'reference' => 'DOU014',
            'name' => 'Impression documents 1 à 10 pages',
            'price' => 10,
            'image' => null,
            'group_id' => Group::find(1),
            'maxQuantity' => 10.00
        ]);

        Service::factory()->create([
            'reference' => 'DOU006',
            'name' => 'Stockage : forfait de 48h par palette',
            'price' => 15,
            'image' => null,
            'group_id' => null,
            'maxQuantity' => null
        ]);

        Service::factory()->create([
            'reference' => 'DOU005',
            'name' => 'Frais de rechargement par coup de fourche',
            'price' => 50,
            'image' => null,
            'group_id' => null,
            'maxQuantity' => null
        ]);

        Service::factory()->create([
            'reference' => 'DOU003',
            'name' => 'Notification à partir du deuxième transit',
            'price' => 15,
            'image' => null,
            'group_id' => Group::find(2),
            'maxQuantity' => null
        ]);

        Service::factory()->create([
            'reference' => 'DOU002',
            'name' => 'Notification d\'un titre de transit',
            'price' => 25,
            'image' => null,
            'group_id' => Group::find(2),
            'maxQuantity' => 1.00
        ]);

        Service::factory()->create([
            'reference' => 'DOU001',
            'name' => 'Ouverture de compte / opening account',
            'price' => 30,
            'image' => null,
            'group_id' => null,
            'maxQuantity' => null
        ]);

    }
}
