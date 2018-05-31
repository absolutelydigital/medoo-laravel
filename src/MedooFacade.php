<?php
namespace absolutelydigital\LaravelMedoo;

use Illuminate\Support\Facades\Facade;

class MedooFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'medoo';
    }
}
