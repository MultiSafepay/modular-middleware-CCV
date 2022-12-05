<?php

namespace ModularTemplate\ModularTemplate\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \ModularTemplate\ModularTemplate\ModularTemplate
 */
class ModularTemplate extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \ModularTemplate\ModularTemplate\ModularTemplate::class;
    }
}
