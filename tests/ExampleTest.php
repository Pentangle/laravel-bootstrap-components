<?php

namespace Pentangle\BootstrapComponents\Tests;

use Orchestra\Testbench\TestCase;
use Pentangle\BootstrapComponents\BootstrapComponentsServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [BootstrapComponentsServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
