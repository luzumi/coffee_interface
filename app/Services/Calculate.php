<?php

namespace App\Services;

use App\Models\CoffeeOrder;
use App\Models\CoffeeVariety;
use App\Models\User;

class Calculate
{

    public static function coffeeOrder(string $coffee_type, int $id): void
    {
        $credit_cost = CoffeeVariety::where('coffee_name', $coffee_type)->first()->credit_cost;
        $user = User::find($id);

        $user->update([
            'credits' => $user->credits - $credit_cost,
        ]);

    }
}
