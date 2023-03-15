<?php

namespace Database\Seeders;

use App\Models\CoffeeOrder;
use App\Models\CoffeeVariety;
use App\Models\RFID_Tag;
use App\Models\User;
use App\Services\RaspUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed RFID tags
        $rfidTags = [
            ['tag_uid' => '182-232-225-89-230', 'role' => 'vip', 'tag_active' => true],
            ['tag_uid' => '214-33-156-27-112', 'role' => 'maintenance', 'tag_active' => true],
            ['tag_uid' => '19-89-65-33-42', 'role' => 'user', 'tag_active' => true],
            ['tag_uid' => '30-92-208-131-17', 'role' => 'user', 'tag_active' => true],
            ['tag_uid' => '16-215-115-162-22', 'role' => 'user', 'tag_active' => true],
            ['tag_uid' => '136-4-117-47-214', 'role' => 'user', 'tag_active' => true]
        ];

        // Seed users
        $users = [
            ['username' => 'vip_user',
                'firstname' => 'VIP',
                'lastname' => 'PRO',
                'credits' => '0',
                'active' => true,
                'remarks' => '',
            ],
            ['username' => 'MAINTENANCE_user',
                'firstname' => 'MAINTENANCE',
                'lastname' => 'MAINTENANCE_PRO',
                'credits' => '0',
                'active' => true,
                'remarks' => '',
            ],
            ['username' => 'user-1000',
                'firstname' => 'user',
                'lastname' => '1000',
                'credits' => '1000',
                'active' => true,
                'remarks' => '',
            ],
            ['username' => 'user-55',
                'firstname' => 'user',
                'lastname' => '55',
                'credits' => '55',
                'active' => true,
                'remarks' => '',
            ],
            ['username' => 'user-0',
                'firstname' => 'user',
                'lastname' => '0',
                'credits' => '0',
                'active' => true,
                'remarks' => '',
            ],
            ['username' => 'user-no-order',
                'firstname' => 'user',
                'lastname' => '0',
                'credits' => '0',
                'active' => true,
                'remarks' => '',
            ]
        ];

        // Create users and associate RFID tags with users
        foreach ($users as $index => $user) {
            $createdUser = User::create($user);
            $rfidTag = $rfidTags[$index];
            $rfidTag['user_id'] = $createdUser->id;
            RFID_Tag::create($rfidTag);
        }

        // Seed coffee varieties
        $coffeeVarieties = [
            ['coffee_name' => 'Coffee',
                'credit_cost' => '50',
                'coffee_image' => 'strong.png',
                'coffee_description' => 'A strong black coffee.',
                'coffee_code' => '1'
            ],
            ['coffee_name' => 'Coffee Double',
                'credit_cost' => '90',
                'coffee_image' => 'strong.png',
                'coffee_description' => 'A strong black coffee.',
                'coffee_code' => '2'
            ],
            ['coffee_name' => 'Espresso',
                'credit_cost' => '60',
                'coffee_image' => 'light.png',
                'coffee_description' => 'A short black coffee.',
                'coffee_code' => '3'
            ],
            ['coffee_name' => 'Espresso Double',
                'credit_cost' => '100',
                'coffee_image' => 'normal.png',
                'coffee_description' => 'A normal black coffee.',
                'coffee_code' => '4'
            ],
            ['coffee_name' => 'Water',
                'credit_cost' => '0',
                'coffee_image' => 'water.png',
                'coffee_description' => 'Gratis Water.',
                'coffee_code' => '5'
            ],
            ['coffee_name' => 'noch keine Auswahl getroffen',
                'credit_cost' => '0',
                'coffee_image' => 'water.png',
                'coffee_description' => 'erster Eintrag eines Users',
                'coffee_code' => '6'
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
