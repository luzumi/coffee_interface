<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'firstname',
        'lastname',
        'tag_id',
        'credits',
        'active',
        'remarks',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
    ];


    /**
     * Definiert die Beziehung zu jeder RFIDService-Tag-Instanz.
     *
     * @return hasMany
     */
    public function rfidTag(): HasMany
    {
        return $this->hasMany(RFID_Tag::class, 'id');
    }

    /**
     * Definiert die Beziehung zu jeder Coffee-Order-Instanz.
     *
     * @return hasMany
     */
    public function coffeeOrders(): HasMany
    {
        return $this->hasMany(CoffeeOrder::class, 'user_id');
    }

}
