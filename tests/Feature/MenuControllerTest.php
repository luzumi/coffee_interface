<?php

namespace Tests\Feature;

use App\Http\Controllers\MenuController;
use App\Models\CoffeeOrder;
use App\Models\CoffeeVariety;
use App\Models\RFID_Tag;
use App\Models\User;
use App\Services\RaspUser;
use Database\Seeders\TestDatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Tests\TestCase;

class MenuControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->seed(TestDatabaseSeeder::class);
    }

    public function test_it_shows_the_menu_page_with_data()
    {
        $user = User::with('coffeeOrders')->find(1);
        RaspUser::setRaspUser($user->id);

        $response = $this->get(route('menu'));

        $response->assertSuccessful();
        $response->assertViewIs('menu');
        $response->assertViewHasAll([
            'viewData' => [
                'user' => $user,
                'varieties' => CoffeeVariety::all(),
                'role' => RFID_Tag::where('user_id', $user->id)->first()->role,
                'rasp_user_entry' => RaspUser::getActualRaspUser(),
            ],
        ]);
    }


    public function test_it_redirects_to_home_page_when_back_button_is_pressed()
    {
        $user = User::find(1);
        RaspUser::setRaspUser($user->id);
        $request = new Request([
            'user_id' => $user->id,
        ]);
        $controller = new MenuController;

        $response = $controller->backToWelcome();

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(route('home'), $response->getTargetUrl());
    }

    public function test_it_returns_an_object_on_in_progress()
    {
        $user = User::find(1);
        RaspUser::setRaspUser($user->id);

        $response = $this->actingAs($user)->get(route('in_progress'));

        $response->assertSuccessful();
        $this->assertIsObject($response->original);
    }


    public function test_it_resets_rasp_user_and_redirects_to_home_page_on_logout()
    {
        $user = User::find(1);
        RaspUser::setRaspUser($user->id);

        $response = $this->actingAs($user)->get(route('logout'));

        $response->assertRedirect('/');
        $this->assertEquals(0, RaspUser::getActualRaspUser()->user_id);
        $this->assertEquals(route('home'), $response->getTargetUrl());
    }


}
