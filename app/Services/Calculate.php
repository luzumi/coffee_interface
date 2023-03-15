<?php

namespace App\Services;

use App\Models\CoffeeVariety;
use App\Models\RFID_Tag;
use App\Models\User;

class Calculate
{
//    public static function coffeeOrder(string $coffee_name, int $id): void
//    {
//        // Abrufen des Kreditkostenwertes für den angegebenen Kaffeenamen
//        $credit_cost = CoffeeVariety::where('coffee_name', $coffee_name)->first()->credit_cost;
//
//        // Abrufen des Benutzers anhand der Benutzer-ID und der Rolle des RFID-Tags
//        $user = User::find($id);
//        $role = RFID_Tag::find($user->tag_id)->role;
//
//        // Wenn der Benutzer VIP oder Maintenance ist, setze die Kreditkosten auf 0
//        if ($role == 'vip' || $role == 'maintenance') {
//            $credit_cost = 0;
//        }
//
//        // Aktualisieren des Kreditwerts des Benutzers um den Kreditkostenwert des Kaffees
//        $user->update([
//            'credits' => $user->credits - $credit_cost,
//        ]);
//    }


    /**
     * Verringert das Kreditguthaben eines Benutzers um die Kosten für einen Kaffeekauf, die durch den Namen des Kaffees bestimmt werden.
     *
     * @param string $coffeeName Der Name des zu kaufenden Kaffees.
     * @param int $userId Die ID des Benutzers, der den Kauf tätigt.
     * @return void
     */
    public static function coffeeOrder(string $coffeeName, int $userId): void
    {
        $coffeeVariety = CoffeeVariety::where('coffee_name', $coffeeName)->firstOrFail();
        $user = User::findOrFail($userId);

        if (self::isFreeCoffeeEligible($user)) {
            return;
        }

        // Verringert das Kreditguthaben des Benutzers um die Kosten des Kaffees.
        $user->decrement('credits', $coffeeVariety->credit_cost);
    }

    /**
     * Überprüft, ob ein Benutzer für einen kostenlosen Kaffee berechtigt ist.
     *
     * Ein Benutzer ist für einen kostenlosen Kaffee berechtigt, wenn er eine VIP- oder Wartungsrolle hat.
     *
     * @param User $user Der Benutzer, für den die Berechtigung überprüft werden soll.
     * @return bool Gibt true zurück, wenn der Benutzer für einen kostenlosen Kaffee berechtigt ist, andernfalls false.
     */
    private static function isFreeCoffeeEligible(User $user): bool
    {
        $tag = RFID_Tag::where('user_id', $user->id)->firstOrFail();

        return in_array($tag->role, ['vip', 'maintenance']);
    }

}
