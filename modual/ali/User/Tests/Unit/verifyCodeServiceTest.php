<?php

namespace ali\User\Tests\Unit;
use ali\User\Services\verifyCodeService;
use Tests\TestCase;

class verifyCodeServiceTest extends TestCase
{

   public function test_generate_code_is_6_digit()
    {

        $code = verifyCodeService::generate();
        $this->assertIsNumeric($code,'generated code is not numeric');
        $this->assertLessThanOrEqual(999999,$code,'generated code is less than 6');
        $this->assertGreaterThanOrEqual(100000,$code,'generated code is greater than 6');
    }
    public function test_verify_code_can_store()
    {
        $code = verifyCodeService::generate();

        verifyCodeService::store('1',$code,120);

        $this->assertEquals($code,cache()->get('verify_code_1'));

    }

}
