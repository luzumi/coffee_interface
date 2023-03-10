<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CoffeeOrder extends Model
{
    protected $fillable = [
        'tag_id',
        'user_id',
        'coffee_name',
    ];

    public function rfidTag(): BelongsTo
    {
        return $this->belongsTo(RFID_Tag::class, 'tag_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function coffeeVariety(): BelongsTo
    {
        return $this->belongsTo(CoffeeVariety::class, 'id');
    }


}

