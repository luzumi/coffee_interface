<?php

namespace App\Services;

use App\Models\CoffeeOrder;
use App\Models\CoffeeVariety;
use App\Models\RFID_Tag;
use App\Models\User;

class Calculate
{

    public static function coffeeOrder(string $coffee_name, int $id): void
    {
        $credit_cost = CoffeeVariety::where('coffee_name', $coffee_name)->first()->credit_cost;
        $user = User::find($id);

        $role = RFID_Tag::find($user->tag_id)->role;
        if ($role == 'vip' || $role == 'maintenance') {
            $credit_cost = 0;
        }

        $user->update([
            'credits' => $user->credits - $credit_cost,
        ]);

    }
}
