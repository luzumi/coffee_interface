<?php

namespace Tests\Feature\Integration;

use App\Services\RaspUser;
use Database\Seeders\TestDatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class RaspUserTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(TestDatabaseSeeder::class);
    }

    public function test_it_sets_and_gets_rasp_user_id()
    {
        // Arrange
        $user_id = 123;

        // Act
        RaspUser::setRaspUser($user_id);
        $result = RaspUser::getActualRaspUser();

        // Assert
        $this->assertEquals($user_id, $result);
    }

    public function test_it_resets_rasp_user_id()
    {
        // Arrange
        $user_id = 123;
        RaspUser::setRaspUser($user_id);

        // Act
        RaspUser::resetRaspUser();
        $result = RaspUser::getActualRaspUser();

        // Assert
        $this->assertEquals(0, $result);
    }

    public function test_it_returns_zero_for_rasp_user_id_if_not_set()
    {
        // Act
        $result = RaspUser::getActualRaspUser();

        // Assert
        $this->assertEquals(0, $result);
    }

    public function test_it_sets_rasp_user_id_to_zero_on_reset()
    {
        // Arrange
        $user_id = 123;
        RaspUser::setRaspUser($user_id);

        // Act
        RaspUser::resetRaspUser();
        $result = DB::table('rasp_users')->where('id', 1)->value('user_id');

        // Assert
        $this->assertEquals(0, $result);
    }

}
