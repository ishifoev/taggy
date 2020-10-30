<?php

use Amalikov\Taggy\TaggyServiceProvider;

abstract class TestCase extends Orchestra\Testbench\TestCase
{
    /**
     * Service provider loading in
     */
   protected function getPackageProvider($app)
   {
       return [TaggyServiceProvider::class];
   }

   /**
    * Set up phpunit
    */
    public function setUp() : void
    {
        parent::setUp();

        Eloquent::unguard();

        $this->loadMigrationsFrom(__DIR__ . '/../migrations');
    }

    /**
     * Drop down the DB lessons
     */
    public function tearDown() : void
    {
        \Schema::drop('lessons');
    }

   /**
    * Enviroment setup
    */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench',[
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => ''
        ]);

        \Schema::create('lessons', function($table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
        });
    }
}