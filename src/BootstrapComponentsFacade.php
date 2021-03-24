<?php

namespace Pentangle\BootstrapComponents;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Pentangle\BootstrapComponents\Skeleton\SkeletonClass
 */
class BootstrapComponentsFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'bootstrap-components';
    }
}
