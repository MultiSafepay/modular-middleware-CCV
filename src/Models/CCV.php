<?php

namespace ModularCCV\ModularCCV\Models;

use Illuminate\Database\Eloquent\Model;

class CCV extends Model
{
    protected $fillable = [
        'public_key',
        'secret_key',
        'domain',
        'redirect_url',
        'multisafepay_api_key',
        'multisafepay_environment'
    ];

    protected $table = 'ccv';
}
