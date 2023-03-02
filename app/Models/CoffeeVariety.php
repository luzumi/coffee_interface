<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CoffeeVariety extends Model
{
    protected $fillable = [
        'coffee_name',
        'credit_cost',
        'coffee_image',
        'coffee_description',
        'coffee_count',
    ];

    public function coffeeOrders(): HasMany
    {
        return $this->hasMany(CoffeeOrder::class, 'coffee_type');
    }
}
