<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessToken extends Model
{
    protected $table = 'access_tokens';

    protected $fillable = [
        'access_token',
        'token_type',
        'expires_in',
        'user_name',
        'issued',
        'expires'
    ];
}
