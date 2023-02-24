<?php

namespace Milwad\LaravelValidate\Tests;

use Milwad\LaravelValidate\Rules\ValidUsername;

class ValidUsernameTest extends BaseTest
{
    /**
     * Set up.
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test username is valid.
     *
     * @test
     *
     * @return void
     */
    public function username_is_valid()
    {
        $rules = ['username' => [new ValidUsername()]];
        $data = ['username' => 'milwad'];
        $passes = $this->app['validator']->make($data, $rules)->passes();

        $this->assertTrue($passes);
    }

    /**
     * Test username is not valid.
     *
     * @test
     *
     * @return void
     */
    public function username_is_not_valid()
    {
        $rules = ['username' => [new ValidUsername()]];
        $data = ['username' => 'milwad!@!'];
        $passes = $this->app['validator']->make($data, $rules)->passes();

        $this->assertFalse($passes);
    }
}
