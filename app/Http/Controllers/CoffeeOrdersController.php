<?php

namespace App\Http\Controllers;

use App\Models\CoffeeOrder;
use App\Models\RFID_Tag;
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

        $coffee_type = $type;

        CoffeeOrder::create([
            'tag_id' => $user->tag_id,
            'username' => $user->username,
            'coffee_type' => $coffee_type,
        ]);

        Calculate::coffeeOrder($coffee_type, $raspUserId);

        return redirect()->route('in_progress');
    }
}
