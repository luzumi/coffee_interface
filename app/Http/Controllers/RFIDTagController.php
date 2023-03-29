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
     * @return RFID_Tag|RFID_Tag|_IH_RFID_Tag_C|null
     */
    public function getTag()
    {
        $id = RaspUser::getActualRaspUser();

        return RFID_Tag::find($id);
    }
}
