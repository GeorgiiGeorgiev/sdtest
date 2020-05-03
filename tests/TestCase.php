<?php

namespace Tests;

use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected $faker;

    use CreatesApplication,DatabaseMigrations,RefreshDatabase;

    public function setUp():void
    {
        parent::setUp();
        $this->faker = Factory::create();
    }
}
