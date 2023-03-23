<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CoffeeVariety extends Model
{
    protected $fillable = [
        'coffee_name',
        'credit_cost',
        'coffee_image',
        'coffee_description',
    ];

    /**
     * Definiert die Beziehung zu der Coffee-Order-Instanz.
     *
     * @return hasMany
     */
    public function coffeeOrders(): HasMany
    {
        return $this->hasMany(CoffeeOrder::class, 'id');
    }
}
