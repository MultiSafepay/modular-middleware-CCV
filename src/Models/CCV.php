<?php

namespace ModularCCV\ModularCCV\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CCV extends Model
{
    use SoftDeletes;

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
