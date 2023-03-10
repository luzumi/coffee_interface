<?php

namespace App\Http\Controllers;

use App\Models\CoffeeOrder;
use App\Models\User;
use App\Services\Calculate;
use App\Services\RaspUser;
use Illuminate\Http\Request;

class CoffeeOrdersController extends Controller
{
    public function newOrder(Request $request, $type)
    {
        $raspUserId = RaspUser::getRaspUserId();
        $user = User::find($raspUserId);
        $coffee_name = $type;

        CoffeeOrder::create([
            'tag_id' => $user->tag_id,
            'user_id' => $user->id,
            'coffee_name' => $coffee_name,
        ]);

        Calculate::coffeeOrder($coffee_name, $raspUserId);

        return redirect()->route('in_progress');
    }
}
