<?php

namespace Database\Seeders;

use App\Models\CoffeeOrder;
use App\Models\CoffeeVariety;
use App\Models\RFID_Tag;
use App\Models\User;
use App\Services\RaspUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed RFID tags
        $rfidTags = [
            ['tag_uid' => '54-121-106-124-89', 'role' => 'vip', 'tag_active' => true],
            ['tag_uid' => '89-54-121-106-124', 'role' => 'maintenance', 'tag_active' => true],
            ['tag_uid' => '124-89-54-121-106', 'role' => 'user', 'tag_active' => true],
            ['tag_uid' => '106-124-89-54-121', 'role' => 'user', 'tag_active' => true],
            ['tag_uid' => '121-106-124-89-54', 'role' => 'user', 'tag_active' => true],
            ['tag_uid' => '54-121-106-124-89', 'role' => 'user', 'tag_active' => true]
        ];
        foreach ($rfidTags as $rfidTag) {
            RFID_Tag::create($rfidTag);
        }

        // Seed users
        $users = [
            ['username' => 'vip_user',
                'firstname' => 'VIP',
                'lastname' => 'PRO',
                'tag_id' => '1',
                'credits' => '0',
                'active' => true,
                'remarks' => '',
            ],
            ['username' => 'MAINTENANCE_user',
                'firstname' => 'MAINTENANCE',
                'lastname' => 'MAINTENANCE_PRO',
                'tag_id' => '2',
                'credits' => '0',
                'active' => true,
                'remarks' => '',
            ],
            ['username' => 'user-1000',
                'firstname' => 'user',
                'lastname' => '1000',
                'tag_id' => '3',
                'credits' => '1000',
                'active' => true,
                'remarks' => '',
            ],
            ['username' => 'user-55',
                'firstname' => 'user',
                'lastname' => '55',
                'tag_id' => '4',
                'credits' => '55',
                'active' => true,
                'remarks' => '',
            ],
            ['username' => 'user-0',
                'firstname' => 'user',
                'lastname' => '0',
                'tag_id' => '5',
                'credits' => '0',
                'active' => true,
                'remarks' => '',
            ],
            ['username' => 'user-no-order',
                'firstname' => 'user',
                'lastname' => '0',
                'tag_id' => '6',
                'credits' => '0',
                'active' => true,
                'remarks' => '',
            ]
        ];
        foreach ($users as $user) {
            User::create($user);
        }

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
            ['coffee_name' => 'noch keine Auswahl getroffen',
                'credit_cost' => '0',
                'coffee_image' => 'water.png',
                'coffee_description' => 'erster Eintrag eines Users'
            ],
        ];
        foreach ($coffeeVarieties as $coffeeVariety) {
            CoffeeVariety::create($coffeeVariety);
        }

        $coffeeOrders = [
            ['tag_id' => '1', 'user_id' => '1', 'coffee_name' => 'Espresso'],
            ['tag_id' => '2', 'user_id' => '2', 'coffee_name' => 'Espresso Double'],
            ['tag_id' => '3', 'user_id' => '3', 'coffee_name' => 'Water'],
            ['tag_id' => '3', 'user_id' => '3', 'coffee_name' => 'Espresso Double'],
            ['tag_id' => '3', 'user_id' => '3', 'coffee_name' => 'Coffee Double'],
            ['tag_id' => '3', 'user_id' => '3', 'coffee_name' => 'Coffee'],
            ['tag_id' => '3', 'user_id' => '3', 'coffee_name' => 'Espresso'],
            ['tag_id' => '4', 'user_id' => '4', 'coffee_name' => 'Coffee Double'],
            ['tag_id' => '4', 'user_id' => '4', 'coffee_name' => 'Coffee'],
            ['tag_id' => '4', 'user_id' => '4', 'coffee_name' => 'Espresso Double'],
            ['tag_id' => '4', 'user_id' => '4', 'coffee_name' => 'Espresso'],
            ['tag_id' => '5', 'user_id' => '5', 'coffee_name' => 'Coffee Double'],
            ['tag_id' => '5', 'user_id' => '5', 'coffee_name' => 'Coffee'],
            ['tag_id' => '5', 'user_id' => '5', 'coffee_name' => 'Espresso Double'],
            ['tag_id' => '5', 'user_id' => '5', 'coffee_name' => 'Espresso'],
        ];
        foreach ($coffeeOrders as $coffeeOrder) {
            CoffeeOrder::create($coffeeOrder);
        }

        DB::insert('insert into rasp_users (id) values (?)', [0]);
        RaspUser::setRaspUser(0);
    }
}
