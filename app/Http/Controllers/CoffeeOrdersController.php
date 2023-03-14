<?php

namespace App\Http\Controllers;

use App\Models\CoffeeOrder;
use App\Models\CoffeeVariety;
use App\Models\User;
use App\Services\Calculate;
use App\Services\RaspUser;
use App\Services\WebhookService;
use Illuminate\Http\Request;

class CoffeeOrdersController extends Controller
{
    public function newOrder(Request $request, $order_number)
    {
        $raspUserId = RaspUser::getRaspUserId();
        $user = User::find($raspUserId);
        $coffee = CoffeeVariety::where('id', $order_number)->first();
        $webhook = new WebhookService();

        CoffeeOrder::create([
            'tag_id' => $user->tag_id,
            'user_id' => $user->id,
            'coffee_name' => $coffee->coffee_name,
        ]);

        Calculate::coffeeOrder($coffee->coffee_name, $raspUserId);
        $webhook->sendWebhookGetCoffee($coffee->coffee_code);

        return redirect()->route('in_progress');
    }
}
