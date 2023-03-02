<?php

namespace App\Http\Controllers;

use App\Models\CoffeeOrder;
use App\Models\CoffeeVariety;
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
     * @param Request $request
     * @return Application|Factory|View
     */
    public function show(Request $request)
    {
        $id = RaspUser::getRaspUserId();
        $user = User::find($id);
        $viewData['channel_url'] = 'No channel url';
        $viewData['user'] = $user;
        $viewData['orders'] = CoffeeOrder::where('username', $user->username)->get();
        $viewData['varieties'] = CoffeeVariety::all();

        return view('menu')->with(compact('viewData'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function backToWelcome(Request $request)
    {
        RaspUser::resetRaspUser($request->get('user_id'));
        return redirect()->route('home');
    }

    public function inProgress()
    {
        $id = RaspUser::getRaspUserId();
        $user = User::find($id);
        $viewData['user'] = $user;
        $viewData['orders'] = CoffeeOrder::where('username', $user->username)->get();
        $viewData['varieties'] = CoffeeVariety::all();

        return view('in_progress')->with(compact('viewData'));
    }
}
