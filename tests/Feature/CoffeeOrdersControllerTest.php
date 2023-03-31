<?php

namespace Tests\Feature;

use App\Http\Middleware\VerifyCsrfToken;
use App\Models\CoffeeOrder;
use App\Models\CoffeeVariety;
use App\Models\User;
use App\Services\Calculate;
use App\Services\RaspUser;
use Database\Seeders\TestDatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CoffeeOrdersControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->seed(TestDatabaseSeeder::class);
    }

    public function test_it_calculates_the_price_of_a_coffee_order()
    {
        $user = User::find(4);
        $coffee_id = 3;
        $credits = $user->credits;
        $price = CoffeeVariety::find($coffee_id)->first()->credits;
        RaspUser::setRaspUser($user->id);

        Calculate::coffeeOrder($coffee_id, $user->id);

        $this->assertEquals($credits - $price, $user->credits);
    }
}
