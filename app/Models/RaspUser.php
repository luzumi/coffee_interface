<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RaspUser extends Model
{
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
}
