<?php

namespace Milwad\LaravelValidate\Tests;

use Milwad\LaravelValidate\Rules\ValidOddNumber;

class ValidOddNumberTest extends BaseTest
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
     * Test number is odd.
     *
     * @test
     * @return void
     */
    public function number_is_odd()
    {
        $rules = ['hashtag' => [new ValidOddNumber()]];
        $data = ['hashtag' => '1025'];
        $passes = $this->app['validator']->make($data, $rules)->passes();

        $this->assertTrue($passes);
    }
}