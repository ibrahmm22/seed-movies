<?php

namespace Ibrahim\Movie\Facades;

use Illuminate\Support\Facades\Facade;

class Movie extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'movie';
    }
}
