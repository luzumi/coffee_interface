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
        $this->seed(TestDatabaseSeeder::class);
    }

    // This test is failing because the middleware VerifyCsrfToken is not being called
    public function test_it_creates_a_new_coffee_order_and_redirects_to_in_progress()
    {
        // Arrange
        $user = User::first();
        RaspUser::setRaspUser($user->id);
        $coffee_name = 'Coffee';

        // Act
        $response = $this->actingAs($user)->post(route('new_order', ['type' => $coffee_name]));

        // Assert
        $response->assertRedirect(route('in_progress'));
        $this->assertEquals(1, CoffeeOrder::count());
        $coffee_order = CoffeeOrder::first();
        $this->assertEquals($user->tag_id, $coffee_order->tag_id);
        $this->assertEquals($user->username, $coffee_order->username);
        $this->assertEquals($coffee_name, $coffee_order->coffee_name);
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('in_progress'), $response->getTargetUrl());
    }

    public function test_it_calculates_the_price_of_a_coffee_order()
    {
        $user = User::find(4);
        $coffee_name = 'coffee';
        $credits = $user->credits;
        $price = CoffeeVariety::where('coffee_name', $coffee_name)->first()->credits;
        RaspUser::setRaspUser($user->id);

        Calculate::coffeeOrder($coffee_name, $user->id);

        $this->assertEquals($credits - $price, $user->credits);
    }
}
