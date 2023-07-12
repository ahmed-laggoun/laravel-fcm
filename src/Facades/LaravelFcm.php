<?php

namespace SmirlTech\LaravelFcm\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelFcm extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return self::class;
    }
}
