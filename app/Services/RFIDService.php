<?php

namespace App\Services;

use App\Models\RFID_Tag;

class RFIDService
{

    /**
     * Gibt die RFID_Tag-Instanz mit der angegebenen UID zurück. Wenn keine RFID_Tag-Instanz mit der angegebenen UID existiert,
     * wird eine neue RFID_Tag-Instanz mit der angegebenen UID und einer neuen User-Instanz erstellt.
     *
     * @param string $tagUid
     * @return
     */
    public static function getRFIDTag(string $tagUid)
    {
        $rfidTag = RFID_Tag::where('tag_uid', $tagUid)->with('user')->first();

        if (is_Null($rfidTag)) {
            $rfidTag = UserService::createNewUserAndTag($tagUid);
        }

        return $rfidTag;
    }
//

    /**
     * Erstellt einen eindeutigen Namenstoken für einen neuen Benutzer. Der Namestoken besteht aus dem Namen des Benutzers
     * und der Anzahl aller Benutzer, umgewandelt in eine Zeichenkette, die bereits in der Datenbank gespeichert sind.
     * Der Namestoken wird verwendet, um einen eindeutigen Benutzernamen für einen neuen Benutzer zu erstellen.
     *
     * @param string $tagUid
     * @param int $userId
     * @return RFID_Tag
     */
    public static function createNewRFIDTag(string $tagUid, int $userId): RFID_Tag
    {
        return RFID_Tag::create([
            'tag_uid' => $tagUid,
            'user_id' => $userId,
            'role' => 'rfid_not_found',
        ]);
    }
}
