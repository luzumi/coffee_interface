<?php

namespace App\Http\Controllers;

use App\Models\CoffeeVariety;
use App\Models\RFID_Tag;
use App\Models\User;
use App\Services\RaspUser;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    /**
     * Zeigt die Menüansicht mit den zugehörigen Daten für den aktuellen Benutzer an.
     *
     * @return Application|Factory|View
     */
    public function show(): View|Factory|Application
    {
        $raspUser = RaspUser::getActualRaspUser();
        $user = User::with('coffeeOrders', 'rfidTag')->find($raspUser->user_id);
        $viewName = $this->getViewName($raspUser, $user);

        if ($viewName !== 'menu') {
            return view($viewName)->with(compact('user'));
        }
//TODO: TAG-UID needed, USER-ID falsch für role Bestimmung
        $rfidTag = RFID_Tag::where('tag_uid', $raspUser->rfid_tag)
            ->first();

        $viewData = [
            'user' => $user,
            'varieties' => CoffeeVariety::all(),
            'role' => $rfidTag->role,
            'rasp_user_entry' => $raspUser,
        ];

        return view('menu')->with(compact('viewData'));
    }

    /**
     * Setzt den RaspUser mit der angegebenen Benutzer-ID zurück und leitet den Benutzer zur "home"-Route weiter.
     *
     * @return Application
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
     * @return Application
     */
    public function logout()
    {
        return $this->backToWelcome();
    }

    /**
     * Zeigt die Ansicht "user_not_found" an.
     *
     * @return Application|Factory|View
     */
    public function userNotFound()
    {
        if (Str::startsWith(RaspUser::getActualRaspUser()->user_id, '8')) {
            return view('card-not-accepted');
        }

        return view('user_not_found');
    }

    /**
     * Zeigt die Ansicht "user_not_found" an.
     *
     * @return Application|Factory|View
     */
    public function notActive()
    {
        return view('not_active');
    }

    public function cardNotAccepted()
    {
        return view('card-not-accepted');
    }

    /**
     * Zeigt die Ansicht "disruption" an.
     *
     * @return Application|Factory|View
     */
    public function needService()
    {
        return view('need_service');
    }

    /**
     * Zeigt die Ansicht "disruption" an.
     *
     * @return Application|Factory|View
     */
    public function disruption()
    {
        return view('disruption');
    }

    /**#
     * Gibt die Ansicht zurück, die abhängig von den Daten des RaspUsers angezeigt werden soll.
     *
     *
     * @param $raspUser
     * @return string
     */
    private function getViewName($raspUser, $user)
    {
//        dd($raspUser, $user);
        if ($raspUser->user_not_found) {
            return 'user_not_found';
        }
        if ($raspUser->need_service) {
            return 'need_service';
        }
        if ($raspUser->disruption) {
            return 'disruption';
        }
        if ($user->active === 0 || RFID_Tag::where('tag_uid', $raspUser->rfid_tag)->first()->tag_active === 0)
        {
            return 'not_active';
        }
        return 'menu';
    }


    public function test()
    {
        return view('test');
    }
}
