<?php

namespace Database\Seeders;

use App\Models\CoffeeOrder;
use App\Models\CoffeeVariety;
use App\Models\RFID_Tag;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed RFIDService tags
        $rfidTags = [
            ['tag_uid' => '182-232-225-89-230', 'role' => 'vip', 'tag_active' => true],
            ['tag_uid' => '214-33-156-27-112', 'role' => 'maintenance', 'tag_active' => true],
            ['tag_uid' => '19-89-65-33-42', 'role' => 'user', 'tag_active' => true],
            ['tag_uid' => '30-92-208-131-17', 'role' => 'user', 'tag_active' => true],
            ['tag_uid' => '16-215-115-162-22', 'role' => 'user', 'tag_active' => true],
            ['tag_uid' => '136-4-117-47-214', 'role' => 'user', 'tag_active' => true]
        ];

        $rawRfidTags = [
            ['111', 'vip', 1, NULL, NULL],
            ['222', 'maintenance', 1, NULL, NULL],
            ['333', 'user', 1, NULL, NULL],
            ['444', 'user', 1, NULL, NULL],
            ['555', 'user', 1, NULL, NULL],
            ['666', 'user', 1, NULL, NULL],
            ['182-232-225-89-230', 'vip', 1, NULL, NULL],
            ['166-233-83-27-7', 'user', 1, NULL, NULL],
            ['19-209-147-33-112', 'user', 1, NULL, NULL],
            ['242-143-241-46-162', 'user', 1, NULL, NULL],
            ['35-74-163-33-235', 'user', 1, NULL, NULL],
            ['214-33-156-27-112', 'maintenance', 0, NULL, NULL],
            ['19-89-65-33-42', 'user', 1, NULL, NULL],
            ['36-38-130-195-67', 'user', 1, NULL, NULL],
            ['30-92-208-131-17', 'user', 1, NULL, NULL],
            ['192-139-189-164-82', 'user', 0, NULL, NULL],
            ['54-121-106-124-89', 'user', 0, NULL, NULL],
            ['86-218-186-48-6', 'maintenance', 1, NULL, NULL],
            ['23-225-130-195-183', 'user', 1, NULL, NULL],
            ['213-11-131-195-158', 'user', 1, NULL, NULL],
            ['54-136-119-124-181', 'user', 1, NULL, NULL],
            ['139-214-129-195-31', 'user', 0, NULL, NULL],
            ['48-161-197-164-240', 'user', 1, NULL, NULL],
            ['150-172-147-89-240', 'user', 1, NULL, NULL],
            ['32-91-194-164-29', 'user', 1, NULL, NULL],
            ['136-4-88-146-70', 'vip', 1, NULL, NULL],
            ['136-4-79-35-224', 'user', 0, NULL, NULL],
            ['136-4-90-101-179', 'user', 1, NULL, NULL],
            ['136-4-1-209-92', 'user', 1, NULL, NULL],
            ['136-4-146-7-25', 'user', 1, NULL, NULL],
            ['136-4-88-5-209', 'user', 1, NULL, NULL],
            ['97-198-48-15-152', 'user', 1, NULL, NULL],
            ['136-4-139-75-76', 'vip', 0, NULL, NULL],
            ['136-4-27-196-83', 'vip', 1, NULL, NULL],
            ['136-4-61-81-224', 'user', 1, NULL, NULL],
            ['136-2-172-26-60', 'user', 1, NULL, NULL],
            ['16-215-115-162-22', 'user', 1, NULL, NULL],
            ['33-34-35-36-4', 'user', 1, NULL, NULL],
            ['136-4-117-47-214', 'user', 1, NULL, NULL],
            ['134-190-78-37-83', 'user', 1, NULL, NULL],
            ['239-145-240-232-102', 'user', 1, NULL, NULL],
            ['136-4-53-36-157', 'user', 1, NULL, NULL],
            ['16-218-121-162-17', 'vip', 1, NULL, NULL],
            ['224-17-205-87-107', 'vip', 1, NULL, NULL],
            ['136-4-32-94-242', 'vip', 1, NULL, NULL],
            ['136-4-73-250-63', 'user', 1, NULL, NULL],
            ['136-4-130-24-22', 'user', 1, NULL, NULL],
            ['136-4-106-10-236', 'user', 1, NULL, NULL],
            ['48-153-201-87-55', 'user', 1, NULL, NULL],
            ['136-4-76-90-154', 'new', 0, NULL, NULL]
        ];

        $rfidTags = [];

        foreach ($rawRfidTags as $row) {
            $rfidTags[] = [
                'tag_uid' => $row[0],
                'role' => $row[1],
                'tag_active' => $row[2] == 1,
                'created_at' => $row[3],
                'updated_at' => $row[4],
            ];
        }

        // Seed users
        $rawusers = [
            ['vip_user', 'TEST-VIP-USER', 'PRO', '0.01', true, ''],
            ['TEST-MAINTENANCE-USER', 'testMAINTENANCE', 'MAINTENANCE_PRO', '0.01', true, ''],
            ['TEST-USER--1000', 'testuser', '1000', '10', true, ''],
            ['TEST-USER-60', 'testuser', '60', '0.60', true, ''],
            ['TEST-USER-0', 'testuser', '0', '0', true, ''],
            ['TEST_USER_NO_ORDER', 'testuser', 'noorder', '0', true, ''],

            ['aseedorf', 'Alex', 'Seedorf', '71', 4, '1', '', NULL, NULL, NULL],
            ['npetermann', 'Nils', 'Petermann', '83', 9999, '1', 'Coffee for free lifetime', NULL, NULL, NULL],
            ['pkaune', 'Peter', 'Kaune', '56', 8, '1', '', NULL, NULL, NULL],
            ['mschall', 'Melanie', 'Schall', '64', 7, '1', '', NULL, NULL, NULL],
            ['csiemer', 'Christine', 'Siemer', '54', 6, '1', '', NULL, NULL, NULL],
            ['cstaden', 'Christian', 'Staden', '52', 3, '1', '', NULL, NULL, NULL],
            ['cfenzl', 'Claudia', 'Fenzl', '41', 2, '1', '', NULL, NULL, NULL],
            ['cnaber', 'Carmen', 'Naber', '72', 3, '1', 'Test', NULL, NULL, NULL],
            ['vharberts', 'Vivian', 'Harberts', '73', 9, '1', '', NULL, NULL, NULL],
            ['iklein', 'Iris', 'Klein', '62', 13, '1', '', NULL, NULL, NULL],
            ['jnaumann', 'Jan', 'Naumann', '58', 1, '1', '', NULL, NULL, NULL],
            ['bschmitt', 'Bianca', 'Schmitt', '53', 1, '1', '', NULL, NULL, NULL],
            ['dschuette', 'Dominik', 'Schütte', '57', 4, '1', '', NULL, NULL, NULL],
            ['alavagno', 'Antonella', 'Lavagno', '42', 12, '1', 'FZHB', NULL, NULL, NULL],
            ['pkucera', 'Paola', 'Kucera', '44', 18, '1', 'FZHB', NULL, NULL, NULL],
            ['kstollmann', 'Kate', 'Stollmann', '48', 28, '1', 'FZHB', NULL, NULL, NULL],
            ['kkuehn', 'Kristina', 'Kühn', '59', 1, '1', '', NULL, NULL, NULL],
            ['jfossiek', 'Janis', 'Fossiek', '47', 9, '1', '', NULL, NULL, NULL],
            ['speters', 'Susanne', 'Peters', '49', 22, '1', '', NULL, NULL, NULL],
            ['cdieterle', 'Christof', 'Dieterle', '78', 56, '1', '', NULL, NULL, NULL],
            ['aseebe', 'Andreas', 'Sebe-Opfermann', '68', 20, '1', '', NULL, NULL, NULL],
            ['hauffarth', 'Hergen', 'Auffarth', '75', 2, '1', '', NULL, NULL, NULL],
            ['lmeyne', 'Lisa', 'Meyne', '43', 25, '1', '', NULL, NULL, NULL],
            ['lartinger', 'Lisa', 'Artinger', '70', 0, '1', '', NULL, NULL, NULL],
            ['mreinhardt', 'Matthias', 'Reinhardt', '74', 1, '1', '', NULL, NULL, NULL],
            ['sroppertz', 'Sophia', 'Roppertz', '55', 22, '1', '', NULL, NULL, NULL],
            ['rjacobs', 'Robin', 'Jacobs', '79', 37, '1', '', NULL, NULL, NULL],
            ['nweinowski', 'Nils', 'Weinowski', '77', 3, '1', '', NULL, NULL, NULL],
            ['ahoppenworth', 'Arne', 'Hoppenworth', '80', 15, '1', '', NULL, NULL, NULL],
            ['Special', 'ITB', 'Bremen', '81', 9999, '1', '', NULL, NULL, NULL],
            ['itbspecial2', 'ITB', 'Special2', '82', 666, '1', '', NULL, NULL, NULL],
            ['praktikanten', 'ITB', 'Praktikanten', '84', 7, '1', 'Abt. Petersen, ITB', NULL, NULL, NULL],
            ['dweerts', 'Daniel', 'Weerts', '85', 4, '1', '', NULL, NULL, NULL],
            ['snamdar', 'Selim', 'Namdar', '86', 1080, '1', '', NULL, NULL, NULL],
            ['owendt', 'Oliver', 'Wendt', '87', 10, '1', '', NULL, NULL, NULL],
        ];

        $users = [];

        foreach ($rawusers as $row) {
            $users[] = [
                'username' => $row[0],
                'firstname' => $row[1],
                'lastname' => $row[2],
                'credits' => $row[3] * 100,
                'active' => $row[4] == 1,
                'remarks' => UserService::getNameToken(count($users) + 1),
            ];
        }
        // Create users and associate RFIDService tags with users
        foreach ($users as $index => $user) {
            $createdUser = User::create($user);
            $rfidTag = $rfidTags[$index];
            $rfidTag['user_id'] = $createdUser->id;
            RFID_Tag::create($rfidTag);
        }

        // Seed coffee varieties
        $coffeeVarieties = [
            ['coffee_name' => 'Kaffee',
                'credit_cost' => '50',
                'coffee_image' => 'strong.png',
                'coffee_description' => 'A strong black coffee.',
                'coffee_code' => 'FA:09'
            ],
            ['coffee_name' => 'Großer Kaffee',
                'credit_cost' => '90',
                'coffee_image' => 'strong.png',
                'coffee_description' => 'A strong black coffee.',
                'coffee_code' => 'FA:0A'
            ],
            ['coffee_name' => 'Espresso',
                'credit_cost' => '60',
                'coffee_image' => 'light.png',
                'coffee_description' => 'A short black coffee.',
                'coffee_code' => 'FA:07'
            ],
            ['coffee_name' => 'Doppelter Espresso',
                'credit_cost' => '100',
                'coffee_image' => 'normal.png',
                'coffee_description' => 'A normal black coffee.',
                'coffee_code' => 'FA:08'
            ],
            ['coffee_name' => 'Heißwasser',
                'credit_cost' => '0',
                'coffee_image' => 'water.png',
                'coffee_description' => 'Gratis Water.',
                'coffee_code' => 'FA:06'
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

//        $coffeeOrders = [
//            ['tag_id' => '1', 'user_id' => '1', 'coffee_name' => 'Espresso'],
//            ['tag_id' => '2', 'user_id' => '2', 'coffee_name' => 'Espresso Double'],
//            ['tag_id' => '3', 'user_id' => '3', 'coffee_name' => 'Water'],
//            ['tag_id' => '3', 'user_id' => '3', 'coffee_name' => 'Espresso Double'],
//            ['tag_id' => '3', 'user_id' => '3', 'coffee_name' => 'Coffee Double'],
//            ['tag_id' => '3', 'user_id' => '3', 'coffee_name' => 'Coffee'],
//            ['tag_id' => '3', 'user_id' => '3', 'coffee_name' => 'Espresso'],
//            ['tag_id' => '4', 'user_id' => '4', 'coffee_name' => 'Coffee Double'],
//            ['tag_id' => '4', 'user_id' => '4', 'coffee_name' => 'Coffee'],
//            ['tag_id' => '4', 'user_id' => '4', 'coffee_name' => 'Espresso Double'],
//            ['tag_id' => '4', 'user_id' => '4', 'coffee_name' => 'Espresso'],
//            ['tag_id' => '5', 'user_id' => '5', 'coffee_name' => 'Coffee Double'],
//            ['tag_id' => '5', 'user_id' => '5', 'coffee_name' => 'Coffee'],
//            ['tag_id' => '5', 'user_id' => '5', 'coffee_name' => 'Espresso Double'],
//            ['tag_id' => '5', 'user_id' => '5', 'coffee_name' => 'Espresso'],
//        ];
//        foreach ($coffeeOrders as $coffeeOrder) {
//            CoffeeOrder::create($coffeeOrder);
//        }

        DB::table('rasp_users')->insert([
            'user_id' => 0,
            'need_service' => false,
            'user_not_found' => false,
            'disruption' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
