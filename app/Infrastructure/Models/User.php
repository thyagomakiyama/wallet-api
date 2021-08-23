<?php

namespace Infrastructure\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

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
}
