<?php

namespace  ali\User\Tests\Unit;

use ali\User\Rules\ValidPassword;
use PHPUnit\Framework\TestCase;

class PasswordValidationTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
  public function test_password_should_not_be_less_than_6_character()
    {
        $result = (new ValidPassword())->passes('', '!aAl3');
        $this->assertEquals(0, $result);
    }
//    public function test_password_should_include_sign_character()
//    {
//        $result = (new ValidPassword())->passes('', 'aAl3eeeeee');
//        $this->assertEquals(0, $result);
//    }
//    public function test_password_should_include_digit_character()
//    {
//        $result = (new ValidPassword())->passes('', 'aAl!eeeeee');
//        $this->assertEquals(0, $result);
//    }
//    public function test_password_should_include_capital_character()
//    {
//        $result = (new ValidPassword())->passes('', 'ael!23eeeeee');
//        $this->assertEquals(0, $result);
//    }
//    public function test_password_should_include_small_character()
//    {
//        $result = (new ValidPassword())->passes('', 'ARL!23RRRR');
//        $this->assertEquals(0, $result);
//    }


}
