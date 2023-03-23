<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RFID_Tag extends Model
{
    protected $table = 'rfid_tags';

    protected $fillable = [
        'tag_uid',
        'role',
        'tag_active',
    ];

    /**
     * Definiert die Beziehung zu der User-Instanz.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id');
    }
    /**
     * Definiert die Beziehung zu jeder Coffee_Order-Instanz.
     *
     * @return hasMany
     */
    public function coffeeOrders(): HasMany
    {
        return $this->hasMany(CoffeeOrder::class, 'id');
    }
}
