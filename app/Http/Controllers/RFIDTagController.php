<?php

namespace App\Http\Controllers;

use App\Models\RFID_Tag;
use App\Services\RaspUser;
use Illuminate\Http\Request;
use LaravelIdea\Helper\App\Models\_IH_RFID_Tag_C;

class RFIDTagController extends Controller
{

    /**
     * Gibt das RFID_tag des aktuellen Raspberry Pi-Benutzers zurück.
     *
     */
    public function getTag()
    {
        $raspUser = RaspUser::getActualRaspUser();
        $userId = $raspUser->user_id;

        return RFID_Tag::find($userId);
    }
}
