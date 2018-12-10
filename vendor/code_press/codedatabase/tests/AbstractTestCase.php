<?php

namespace CodePress\CodeDatabase\Tests;

use Orchestra\Testbench\TestCase;

abstract class AbstractTestCase extends TestCase
{
    public function migrate()
    {
        $this->artisan('migrate', [
            '--path' => '../../../../tests/resources/migrations'
        ]);
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }
}