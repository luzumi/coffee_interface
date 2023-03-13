<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class RaspUser
{
    /**
     * Get the current Raspberry Pi user ID.
     *
     * @return int
     */
    public static function getRaspUserId(): int
    {
        $data = DB::table('rasp_users')->where('id', 1)->first();
        return $data->user_id;
    }

    /**
     * Reset the Raspberry Pi user ID to 0.
     *
     * @return void
     */
    public static function resetRaspUser(): void
    {
        DB::table('rasp_users')->where('id', 1)->update(['user_id' => 0]);
    }

    /**
     * Set the Raspberry Pi user ID to the given value and log the event.
     *
     * @param int $user_id The new Raspberry Pi user ID.
     * @return void
     */
    public static function setRaspUser($user_id): void
    {
        \Log::info('New Login from Raspberry Pi with ID: ' . $user_id);

        DB::table('rasp_users')->where('id', 1)->update(['user_id' => $user_id]);
    }
}
