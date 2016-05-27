<?php

namespace PurpleObject\Factuursturen\Facades;

class FactuurSturen extends \Illuminate\Support\Facades\Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'factuursturen';
    }
}