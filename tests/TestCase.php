<?php

namespace DanialPanah\PerfectMoneyGateway\Tests;

use DanialPanah\PerfectMoneyGateway\PMGatewayServiceProvider;
use Faker\Factory;
use Faker\Generator;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * A Faker fake data generator.
     * @var Generator
     */
    protected $faker;

    public function setUp(): void
    {
        //Create a new faker instance
        $this->faker = Factory::create();

        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            PMGatewayServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // some env setup
    }
}