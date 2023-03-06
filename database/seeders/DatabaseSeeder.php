<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\CoffeeOrder;
use App\Models\CoffeeVariety;
use App\Models\RFID_Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//        $users = [
//            ['username' => 'kkuehn',
//                'firstname' => 'Kristina',
//                'lastname' => 'Kühn',
//                'tag_id' => '59',
//                'credits' => '10',
//                'active' => true,
//                'remarks' => ''],
//
//        ];
//        foreach ($users as $user) {
//            User::create($user);
//        }
//
//        // Seed RFID tags
//        $rfidTags = [
//            ['uid' => '54-121-106-124-89', 'role' => 'user', 'tag_active' => true],
//        ];
//        foreach ($rfidTags as $rfidTag) {
//            RFID_Tag::create($rfidTag);
//        }

        // Seed coffee varieties
        $coffeeVarieties = [

            ['coffee_name' => 'Coffee',
                'credit_cost' => '50',
                'coffee_image' => 'strong.png',
                'coffee_description' => 'A strong black coffee.'
            ],
            ['coffee_name' => 'Coffee Double',
                'credit_cost' => '90',
                'coffee_image' => 'strong.png',
                'coffee_description' => 'A strong black coffee.'
            ],
            ['coffee_name' => 'Espresso',
                'credit_cost' => '60',
                'coffee_image' => 'light.png',
                'coffee_description' => 'A short black coffee.'
            ],
            ['coffee_name' => 'Espresso Double',
                'credit_cost' => '100',
                'coffee_image' => 'normal.png',
                'coffee_description' => 'A normal black coffee.'
            ],
            ['coffee_name' => 'Water',
                'credit_cost' => '0',
                'coffee_image' => 'water.png',
                'coffee_description' => 'Gratis Water.'
            ],
        ];
        foreach ($coffeeVarieties as $coffeeVariety) {
            CoffeeVariety::create($coffeeVariety);
        }

//        $coffeeOrders = [
//            ['tag_id' => '59', 'username' => 'kkuehn', 'coffee_type' => 'Espresso'],
//            ['tag_id' => '59', 'username' => 'kkuehn', 'coffee_type' => 'Cappuccino'],
//        ];
//        foreach ($coffeeOrders as $coffeeOrder) {
//            CoffeeOrder::create($coffeeOrder);
//        }
    }
}
