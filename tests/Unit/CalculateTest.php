<?php

namespace Tests\Unit;

use App\Models\CoffeeVariety;
use App\Models\RFID_Tag;
use App\Models\User;
use App\Services\Calculate;
use Database\Seeders\TestDatabaseSeeder;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CalculateTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->seed(TestDatabaseSeeder::class);
    }

    public function test_it_calculates_the_price_of_a_coffee_order()
    {
        $tag = RFID_Tag::with('user')->where('role', 'user')->first();

        $credits = $tag->user->credits;
        $coffee_id = 3;
        $price = CoffeeVariety::find($coffee_id)->credit_cost;

        Calculate::coffeeOrder($coffee_id, $tag->user->id);

        $tag->refresh();
        $this->assertEquals( 'test_it_calculates_the_price_of_a_coffee_order',$credits - $price, $tag->user->credits);
    }

    public function test_it_calculates_the_price_of_a_vip_coffee_order()
    {
        $tag = RFID_Tag::with('user')->where('role', 'vip')->first();

        $credits = $tag->user->credits;
        $coffee_id = 3;

        Calculate::coffeeOrder($coffee_id, $tag->user->id);

        $tag->refresh();
        $this->assertEquals('test_it_calculates_the_price_of_a_vip_coffee_order', $credits - 0, $tag->user->credits);
    }

    public function test_it_calculates_the_price_of_a_maintenance_coffee_order()
    {
        $tag = RFID_Tag::with('user')->where('role', 'maintenance')->first();

        $credits = $tag->user->credits;
        $coffee_id = 3;

        Calculate::coffeeOrder($coffee_id, $tag->user->id);

        $tag->refresh();
        $this->assertEquals($credits - 0, $tag->user->credits);
    }
}


