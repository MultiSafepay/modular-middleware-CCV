<?php

namespace ModularCCV\ModularCCV\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \ModularCCV\ModularCCV\ModularCCV
 */
class ModularCCV extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \ModularCCV\ModularCCV\ModularCCV::class;
    }
}
