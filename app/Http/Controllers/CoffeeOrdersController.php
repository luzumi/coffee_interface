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
    public function newOrder(Request $request)
    {
        $raspUserId = RaspUser::getRaspUserId();
        $user = User::find($raspUserId);
        $rfid = RFID_Tag::where('id', $user->tag_id)->first();
        $coffee_type = $request->get('type');

        CoffeeOrder::create([
            'tag_id' => $rfid->id,
            'username' => $user->username,
            'coffee_type' => $coffee_type,
        ]);

        Calculate::coffeeOrder($coffee_type, $raspUserId);

        return redirect()->route('in_progress');
    }
}
