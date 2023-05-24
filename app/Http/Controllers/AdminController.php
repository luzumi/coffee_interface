<?php

namespace App\Http\Controllers;

use App\Models\CoffeeVariety;
use App\Models\RFID_Tag;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.admin');
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

    public function manageRFIDs()
    {
        $viewData = [
            'rfid' => RFID_Tag::with('user')->get()->reverse()
        ];

        return view('admin.manage-rfids')
            ->with(compact('viewData'));
    }

    public function editRFID($id)
    {
        $rfid['actual'] = RFID_Tag::with('user')->find($id);
        $rfid['allUsers'] = User::all()->reverse();
        $rfid['roles'] = ['VIP', 'User', 'Maintenance'];
        return view('admin.edit-rfid', compact('rfid'));
    }

    public function manageCats()
    {
        $viewData = [
            'cats' => CoffeeVariety::all(),
        ];

        return view('admin.manage-cats')
            ->with(compact('viewData'));
    }

    public function editCats($id)
    {
        $viewData['cats'] = CoffeeVariety::findOrFail($id);

        return view('admin.edit-cats', compact('viewData'));
    }

    public function helpDisplay()
    {
        return view('admin-help');
    }

}
