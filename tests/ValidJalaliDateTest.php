<?php

namespace Milwad\LaravelValidate\Tests;

use Milwad\LaravelValidate\Rules\ValidJalaliDate;

class ValidJalaliDateTest extends BaseTest
{
    /**
     * Set up.
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test jalali date is correct.
     *
     * @test
     *
     * @return void
     */
    public function jalali_date_is_correct()
    {
        $rules = ['jalali_date' => [new ValidJalaliDate()]];
        $data = ['jalali_date' => '1384/8/25'];
        $passes = $this->app['validator']->make($data, $rules)->passes();

        $this->assertTrue($passes);
    }

    /**
     * Test jalali date is not correct.
     *
     * @test
     *
     * @return void
     */
    public function jalali_date_is_not_correct()
    {
        $rules = ['jalali_date' => [new ValidJalaliDate()]];
        $data = ['jalali_date' => '2016/15/25'];
        $passes = $this->app['validator']->make($data, $rules)->passes();

        $this->assertFalse($passes);
    }
}
