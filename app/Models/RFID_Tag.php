<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RFID_Tag extends Model
{
    protected $fillable = [
        'uid',
        'role',
        'tag_active',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tag_id');
    }

    public function coffeeOrders(): HasMany
    {
        return $this->hasMany(CoffeeOrder::class, 'tag_uid');
    }
}
