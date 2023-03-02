<?php

namespace App\Http\Controllers;

use App\Models\RFID_Tag;
use App\Services\RaspUser;
use Illuminate\Http\Request;

class RFIDTagController extends Controller
{
    public function getTag()
    {
        $id = RaspUser::getRaspUserId();

        return RFID_Tag::find($id);
    }
}
