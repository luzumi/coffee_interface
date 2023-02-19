<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class RaspUser
{
    public static function getRaspUserId(): int
    {
        $data = DB::table('rasp_users')->first('user_id');

        return $data->user_id;
    }

    public static function resetRaspUser(): void
    {
        DB::table('rasp_users')->where('id', 1)->update(['user_id' => 0]);
    }

    public static function setRaspUser($user_id): void
    {
        \Log::info('New Login from Raspberry Pi with ID: ' . $user_id);
        DB::table('rasp_users')->where('id', 1)->update(['user_id' => $user_id]);
    }
}
