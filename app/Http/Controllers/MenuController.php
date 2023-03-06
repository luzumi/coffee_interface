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
        $orders = CoffeeOrder::where('username', $user->username)->get();
        if(isset($orders)) {
            CoffeeOrder::create([
                'tag_id' => $user->tag_id,
                'username' => $user->username,
                'coffee_type' => 'noch keine',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
        $orders = CoffeeOrder::where('username', $user->username)->get();
        $viewData['channel_url'] = 'No channel url';
        $viewData['user'] = $user;
        $viewData['orders'] = $orders;
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

        RaspUser::resetRaspUser();

        return view('in_progress')->with(compact('viewData'));
    }

    public function logout()
    {
        RaspUser::resetRaspUser();
        return redirect()->route('home');
    }
}
