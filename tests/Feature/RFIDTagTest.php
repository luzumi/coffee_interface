<?php

namespace Tests\Feature;

use App\Http\Controllers\RFIDTagController;
use App\Models\RFID_Tag;
use App\Models\User;
use App\Services\RaspUser;
use Database\Seeders\TestDatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RFIDTagTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(TestDatabaseSeeder::class);
    }

    public function test_it_returns_the_correct_rfid_tag()
    {
        // Arrange
        $user = User::find(1);
        RaspUser::setRaspUser($user->id);

        $expectedTag = RFID_Tag::where('id', $user->tag_id)->first();

        // Act
        $controller = new RFIDTagController();
        $tag = $controller->getTag();

        // Assert
        $this->assertEquals($expectedTag->id, $tag->id);
        $this->assertEquals($expectedTag->tag_number, $tag->tag_number);
        $this->assertEquals($expectedTag->role, $tag->role);
        // Add more assertions for other properties as needed
    }

//    // This test not working
//    // This test is for add a new RFID_Tag
//    public function test_it_returns_rfid_tag_for_authenticated_user()
//    {
//        // Arrange
//        $id = User::count() + 1;
//        RaspUser::setRaspUser($id);
//        $rfidTag = RFID_Tag::create([
//            'tag_uid' => $this->faker->randomNumber(4),
//            'role' => $this->faker->randomElement(['vip', 'user']),
//            'tag_active' => true,
//        ]);
//        $user = User::create([
//            'username' => $this->faker->userName(),
//            'firstname' => $this->faker->firstName(),
//            'lastname' => $this->faker->lastName(),
//            'tag_id' => $rfidTag->id,
//            'credits' => $this->faker->randomNumber(4),
//            'active' => true,
//            'remarks' => $this->faker->text(50),
//        ]);
//
//        // Act
//        $response = $this->actingAs($user)->get(route('get_tag'));
//
//        // Assert
//        $response->assertOk();
//        $response->assertJson([
//            'id' => $rfidTag->id,
//            'role' => $rfidTag->role,
//            'tag_id' => $rfidTag->tag_id,
//        ]);
//    }
}
