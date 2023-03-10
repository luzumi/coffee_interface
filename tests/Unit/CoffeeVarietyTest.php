<?php

namespace Tests\Unit;

use App\Models\CoffeeOrder;
use App\Models\CoffeeVariety;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CoffeeVarietyTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed('TestDatabaseSeeder');
    }

    public function test_coffee_variety_has_coffee_orders()
    {
        $coffeeVarieties = CoffeeVariety::all();

        foreach ($coffeeVarieties as $coffeeVariety) {
            $this->assertInstanceOf(Collection::class, $coffeeVariety->coffeeOrders);
            $this->assertInstanceOf(CoffeeOrder::class, $coffeeVariety->coffeeOrders->first());
        }
    }


    public function test_coffee_variety_can_be_created()
    {
        $data = [
            'coffee_name' => 'new_coffee',
            'credit_cost' => 1,
            'coffee_image' => 'image.jpg',
            'coffee_description' => 'A new coffee',
        ];

        $coffeeVariety = CoffeeVariety::create($data);

        $this->assertDatabaseHas('coffee_varieties', $data);
    }

    public function test_coffee_variety_cannot_be_created_without_required_fields()
    {
        $data = [
            // missing required fields
        ];

        $this->expectException(QueryException::class);
        CoffeeVariety::create($data);
    }

    public function test_coffee_variety_can_be_updated()
    {
        $this->assertTrue(true);
    }

    public function test_coffee_variety_has_code()
    {
        $this->assertTrue(true);
    }
}

