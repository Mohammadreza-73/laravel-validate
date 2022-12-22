<?php

namespace Milwad\LaravelValidate\Tests;

use Milwad\LaravelValidate\Rules\ValidCarNumber;

class ValidCarNumberTest extends BaseTest
{
    /**
     * Set up.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test car number is valid.
     *
     * @test
     * @return void
     */
    public function car_number_is_valid()
    {
        $rules = ['capital_char_with_number' => [new ValidCarNumber()]];
        $data = ['capital_char_with_number' => 'KA01AB1234'];
        $passes = $this->app['validator']->make($data, $rules)->passes();

        $this->assertTrue($passes);
    }
}