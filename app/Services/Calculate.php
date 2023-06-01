<?php

namespace App\Services;

use App\Models\CoffeeVariety;
use App\Models\RFID_Tag;
use App\Models\User;
use Illuminate\Support\Str;

class Calculate
{
    /**
     * Verringert das Kreditguthaben eines Benutzers um die Kosten für einen Kaffeekauf, die durch den Namen des Kaffees bestimmt werden.
     *
     * @param int $coffee_id
     * @param int $userId Die ID des Benutzers, der den Kauf tätigt.
     * @return void
     */
    public static function coffeeOrder(int $coffee_id, int $userId): void
    {
        $coffeeVariety = CoffeeVariety::findOrFail($coffee_id);
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

        return in_array(Str::lower($tag->role), ['vip', 'maintenance']);
    }

}
