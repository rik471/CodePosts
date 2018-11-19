<?php
namespace CodePress\CodePosts\Tests;

use Orchestra\Testbench\TestCase;

abstract class AbstractTestCase extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }
    public function migrate()
    {
        $this->artisan('migrate', [
            '--path' => '../../../../src/resources/migrations'
        ]);
    }

    public function getPackageProviders($app)
    {
        return [
          \Cviebrock\EloquentSluggable\SluggableServiceProvider::class
        ];
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