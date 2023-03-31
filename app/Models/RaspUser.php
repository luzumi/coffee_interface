<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RaspUser extends Model
{

    protected $table = 'rasp_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'need_service',
        'user_not_found',
        'disruption',
    ];

    /**
     * Definiert die Beziehung zu der RFID_Tag-Instanz.
     *
     * @return HasOne
     */
    public function rfidTag(): HasOne
    {
        return $this->hasOne(RFID_Tag::class, 'user_id');
    }

    /**
     * Definiert die Beziehung zu der User-Instanz.
     *
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id');
    }
}
