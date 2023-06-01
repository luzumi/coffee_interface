<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RaspUser
{
    /**
     * Gibt den aktuellen Raspberry Pi-Benutzers zurück.
     *
     */
    public static function getActualRaspUser()
    {
        return DB::table('rasp_users')->where('id', 1)->first();
    }

    /**
     * Setzt die Benutzer-ID des aktuellen Raspberry Pi-Benutzers auf 0 zurück.
     *
     * @return void
     */
    public static function resetRaspUser(): void
    {
        DB::table('rasp_users')->where('id', 1)->update([
            'user_id' => 0,
            'disruption' => false,
            'user_not_found' => false,
            'need_service' => false,
        ]);
    }

    /**
     * Setzt die Benutzer-ID des aktuellen Raspberry Pi-Benutzers und aktualisiert optionale Flags.
     *
     * @param int $user_id
     * @param bool $disruption Optionaler Parameter für eine Störung an der Kaffeemaschine, standardmäßig auf 'false' gesetzt
     * @param bool $user_not_found Optionaler Parameter für einen unbekannten Benutzer, standardmäßig auf 'false' gesetzt
     * @param bool $service Optionaler Parameter für Serviceeingriff nötig an der Kaffeemaschine, standardmäßig auf 'false' gesetzt
     * @return void
     */
    public static function setRaspUser(int  $user_id,
                                       bool $disruption = false,
                                       bool $user_not_found = false,
                                       bool $service = false): void
    {
        Log::info('New Login from Raspberry Pi with ID: ' . $user_id);

        DB::table('rasp_users')->where('id', 1)
            ->update([
                'user_id' => $user_id,
                'disruption' => $disruption,
                'user_not_found' => $user_not_found,
                'need_service' => $service
            ]);
    }
}
