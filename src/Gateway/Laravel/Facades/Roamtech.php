<?php

namespace Elimuswift\Mpesa\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Roamtech.
 *
 * @category PHP
 *
 * @author  Leitato Albert <wizqydy@gmail.com>
 */
class Roamtech extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'roamtech.client';
    }
}
