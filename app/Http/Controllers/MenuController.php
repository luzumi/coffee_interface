<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function show(Request $request)
    {
        \Log::info("SHOW: " .  implode(" ", $request->all()));
        if ($request->has('name') && $request->has('channel_url') && $request->has('user_id')) {
            $viewData['name'] = $request->get('name');
            $viewData['channel_url'] = $request->get('channel_url');
            $viewData['user'] = User::find($request->get('user_id'));
        } else {
            $id = DB::table('rasp_users')->first()->user_id;
            \Log::info("USER_ID: " . $id);
            $user = User::find($id);
            $viewData['channel_url'] = 'No channel url';
            $viewData['user'] = $user;
            \Log::info("viewData: " . implode(" ", $viewData));
        }
        return view('menu')->with(compact('viewData'));
    }
}
