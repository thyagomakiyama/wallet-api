<?php

namespace Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, string $param)
 */
class User extends Model
{
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'document_number',
        'user_type'
    ];

    public $incrementing = false;

    public $keyType = 'string';
}
