<?php

namespace  ali\user\Tests\Unit;

use ali\user\Rules\ValidMobile;
use PHPUnit\Framework\TestCase;

class MobileValidationTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_mobile_can_not_be_less_than_10_character()
    {
        $result = (new ValidMobile())->passes('', '93729995311');
        $this->assertEquals(0, $result);
    }
    public function test_mobile_can_not_be_more_than_10_character()
    {
        $result = (new ValidMobile())->passes('', '93729995311');
        $this->assertEquals(0, $result);
    }
    public function test_mobile_must_start_by_9()
    {
        $result = (new ValidMobile())->passes('', '8372999531');
        $this->assertEquals(0, $result);
    }
}
