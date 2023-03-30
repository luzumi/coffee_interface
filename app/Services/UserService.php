<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class UserService
{

    /**
     * Erstellt einen neuen Benutzer und eine neue RFID_Tag-Instanz mit der angegebenen UID und der ID des neuen Benutzers.
     * Der neue Benutzer wird anschließend als RaspUser gesetzt.
     * Wenn der Benutzer nicht gefunden wurde, wird eine entsprechende Response zurückgegeben.
     *
     * @param string $tagUid
     *
     * @return Redirector|Application|RedirectResponse
     */
    public static function createNewUserAndTag(string $tagUid): Redirector|Application|RedirectResponse
    {
        $user = self::createNewUser();

        RFIDService::createNewRFIDTag($tagUid, $user->id);

        RaspUser::setRaspUser($user->id, false, true);

        return redirect('/user_not_found')->with(compact('user'));
    }

    /**
     * Erstellt einen neuen Benutzer mit einem eindeutigen Benutzernamen, der aus dem Namen des Benutzers und der Anzahl
     * aller Benutzer besteht, die bereits in der Datenbank gespeichert sind.
     * Der Namestoken wird verwendet, um einen eindeutigen Benutzernamen für einen neuen Benutzer zu erstellen.
     *
     * @return User
     */
    public static function createNewUser(): User
    {
        return User::create([
            'username' => 'newUser: ' . self::getNameToken(User::count()),
        ]);
    }

    /**
     * Erstellt einen eindeutigen Namenstoken für einen neuen Benutzer. Der Namestoken besteht aus dem Namen des Benutzers
     * und der Anzahl aller Benutzer, umgewandelt in eine Zeichenkette, die bereits in der Datenbank gespeichert sind.
     *
     * @param $integer int Wert der die Anzahl der User in der Datenbank angibt
     * @return string NameToken, zur Identifizierung des neuen Users
     */
    private static function getNameToken(int $integer): string
    {
        $result = "";
        while ($integer > 0) {
            $remainder = ($integer - 1) % 26;
            $result = chr(65 + $remainder) . $result;
            $integer = floor(($integer - 1) / 26);
        }
        return $result;
    }
}