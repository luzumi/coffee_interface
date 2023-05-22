<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin');
    }

    public function manageUsers()
    {
        $viewData = [
            'user' => User::all()->reverse()
        ];

        return view('admin.manage-users')
            ->with(compact('viewData'));
    }

    public function editUser($id)
    {
        $user['actual'] = User::with('rfidTag')->find($id);
        $user['all'] = User::all();

        return view('admin.edit-user', compact('user'));
    }

}
