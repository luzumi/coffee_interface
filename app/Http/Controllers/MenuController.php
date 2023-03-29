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
        $raspUser = RaspUser::getActualRaspUser();
        $user = User::find($raspUser->user_id);

        if ($raspUser->user_not_found) {
            return view('user_not_found')->with(compact('user'));
        }

        $user = User::find($raspUser->user_id);
        $rfidTag = RFID_Tag::where('user_id', $user->id)->first();

        $viewData = [
            'user' => $user,
            'orders' => $user->coffeeOrders,
            'varieties' => CoffeeVariety::all(),
            'role' => $rfidTag->role,
            'rasp_user_entry' => $raspUser,
        ];

        return view('menu')->with(compact('viewData'));
    }



    /**
     * Setzt den RaspUser mit der angegebenen Benutzer-ID zurück und leitet den Benutzer zur "home"-Route weiter.
     *
     * @return Application|Factory|View
     */
    public function backToWelcome()
    {
        RaspUser::resetRaspUser();

        return redirect('/');
    }


    /**
     * Zeigt die "in_progress"-Ansicht für den aktuellen Benutzer und setzt den RaspUser zurück, wenn die Rolle nicht "maintenance" ist.
     *
     * @return View
     */
    public function inProgress()
    {
        $raspUserId = RaspUser::getActualRaspUser();
        $user = User::find($raspUserId->user_id);
        $rfidTag = RFID_Tag::where('user_id', $user->id)->first();

        if ($rfidTag->role !== 'maintenance') {
            RaspUser::resetRaspUser();
        }

        $viewData = [
            'user' => $user,
            'orders' => $user->coffeeOrders,
            'varieties' => CoffeeVariety::all(),
            'role' => $rfidTag->role,
        ];

        return view('in_progress')->with(compact('viewData'));
    }



    /**
     * Setzt den RaspUser zurück und leitet den Benutzer zur "home"-Route weiter.
     *
     * @return RedirectResponse
     */
    public function logout()
    {
        return $this->backToWelcome();
    }

    public function userNotFound()
    {
        return view('user_not_found');
    }

}
