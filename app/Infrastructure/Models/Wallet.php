<?php

namespace Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, string $id)
 */
class Wallet extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'balance'
    ];
}
