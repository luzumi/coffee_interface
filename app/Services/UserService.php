<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
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
    public static function getNameToken(int $integer): string
    {
        $result = "";
        while ($integer > 0) {
            $remainder = ($integer - 1) % 26;
            $result = chr(65 + $remainder) . $result;
            $integer = floor(($integer - 1) / 26);
        }
        return $result;
    }

    public function update(Request $request, $id): Redirector|Application|RedirectResponse
    {
        $user = User::find($id);
        
        $user->username = $request->username;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->credits += $request->credits;
        $user->active = $request->active;
        // Update any other fields you have

        $user->save();

        return redirect('admin/users');
    }

    public function delete($id): Redirector|Application|RedirectResponse
    {
        User::findOrFail($id)->delete();

        return redirect('admin/rfids');
    }
}
