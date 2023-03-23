<?php

namespace App\Http\Controllers;

use App\Models\CoffeeOrder;
use App\Models\CoffeeVariety;
use App\Models\RFID_Tag;
use App\Models\User;
use App\Services\Calculate;
use App\Services\RaspUser;
use App\Services\WebhookService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Ratchet\RFC6455\Messaging\Message;

class CoffeeOrdersController extends Controller
{
    /**
     * Erstellt eine neue Kaffeebestellung und sendet einen Webhook, um den Kaffee basierend auf der Bestellnummer zu holen.
     *
     * @param Request $request
     * @param $order_number
     * @return RedirectResponse
     */
    public function newOrder(Request $request, $order_number)
    {
        $raspUser = RaspUser::getRaspUserId();
        $rfidTag = RFID_Tag::where('user_id', $raspUser->user_id)->with('user')->first();
        $coffee = CoffeeVariety::findOrFail($order_number);
        $webhook = new WebhookService();

        CoffeeOrder::create([
            'tag_id' => $rfidTag->id,
            'user_id' => $rfidTag->user->id,
            'coffee_name' => $coffee->coffee_name,
        ]);

        Calculate::coffeeOrder($coffee->id, $raspUser->user_id);
        $webhook->sendWebhookGetCoffee($coffee->coffee_code);

        return redirect()->route('in_progress')->with(compact('rfidTag'));
    }
}
