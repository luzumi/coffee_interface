<?php

namespace App\Http\Controllers;

use App\Models\CoffeeOrder;
use App\Models\CoffeeVariety;
use App\Models\RFID_Tag;
use App\Models\User;
use App\Services\RaspUser;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Zeigt die Menüansicht mit den zugehörigen Daten für den aktuellen Benutzer an.
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function show(Request $request)
    {
        $raspUserId = RaspUser::getRaspUserId();
        $user = User::with('coffeeOrders')->find($raspUserId->user_id);
        $rfidTag = RFID_Tag::where('user_id', $user->id)->first();

        $viewData = [
            'user' => $user,
            'orders' => $user->coffeeOrders,
            'varieties' => CoffeeVariety::all(),
            'role' => $rfidTag->role,
            'rasp_user_entry' => $raspUserId,
        ];

        return view('menu')->with(compact('viewData'));
    }



    /**
     * Setzt den RaspUser mit der angegebenen Benutzer-ID zurück und leitet den Benutzer zur "home"-Route weiter.
     *
     * @return RedirectResponse
     */
    public function backToWelcome()
    {
        RaspUser::resetRaspUser();
        return redirect()->route('home');
    }


    /**
     * Zeigt die "in_progress"-Ansicht für den aktuellen Benutzer und setzt den RaspUser zurück, wenn die Rolle nicht "maintenance" ist.
     *
     * @return View
     */
    public function inProgress()
    {
        $raspUserId = RaspUser::getRaspUserId();
        $user = User::find($raspUserId->user_id);
        $rfidTag = RFID_Tag::where('user_id', $user->id)->first();

        $viewData = [
            'user' => $user,
            'orders' => $user->coffeeOrders,
            'varieties' => CoffeeVariety::all(),
            'role' => $rfidTag->role,
        ];

        if ($viewData['role'] !== 'maintenance') {
            RaspUser::resetRaspUser();
        }

        return view('in_progress')->with(compact('viewData'));
    }



    /**
     * Setzt den RaspUser zurück und leitet den Benutzer zur "home"-Route weiter.
     *
     * @return RedirectResponse
     */
    public function logout()
    {
        RaspUser::resetRaspUser();
        return redirect()->route('home');
    }

}
