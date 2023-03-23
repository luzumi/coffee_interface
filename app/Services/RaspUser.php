<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class RaspUser
{
    /**
     * Gibt den aktuellen RaspUser-Eintrag zurück.
     *
     * @return Model|Builder|null
     */
    public function getRaspUser(): Model|Builder|null
    {
        return DB::table('rasp_users')->where('id', 1)->first();
    }

    /**
     * Gibt die ID des aktuellen Raspberry Pi-Benutzers zurück.
     *
     * @return Model|Builder
     */
    public static function getRaspUserId(): Model|Builder
    {
        return DB::table('rasp_users')->where('id', 1)->first()->user_id;
    }

    /**
     * Setzt die Benutzer-ID des aktuellen Raspberry Pi-Benutzers auf 0 zurück.
     *
     * @return void
     */
    public static function resetRaspUser(): void
    {
        DB::table('rasp_users')->where('id', 1)->update(['user_id' => 0]);
    }

    /**
     * Setzt die Benutzer-ID des aktuellen Raspberry Pi-Benutzers und aktualisiert optionale Flags.
     *
     * @param int $user_id
     * @param bool $disruption Optionaler Parameter für eine Störung an der Kaffeemaschine, standardmäßig auf 'false' gesetzt
     * @param bool $user_not_found Optionaler Parameter für einen unbekannten Benutzer, standardmäßig auf 'false' gesetzt
     * @param bool $service Optionaler Parameter für Serviceeingriff nötig an an der Kaffeemaschine, standardmäßig auf 'false' gesetzt
     * @return void
     */
    public static function setRaspUser(int  $user_id,
                                       bool $disruption = false,
                                       bool $user_not_found = false,
                                       bool $service = false): void
    {
        \Log::info('New Login from Raspberry Pi with ID: ' . $user_id);

        DB::table('rasp_users')->where('id', 1)
            ->update([
                'user_id' => $user_id,
                'disruption' => $disruption,
                'user_not_found' => $user_not_found,
                'service' => $service
            ]);
    }
}
