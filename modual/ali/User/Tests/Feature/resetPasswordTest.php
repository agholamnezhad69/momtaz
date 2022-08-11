<?php

namespace ali\User\Tests\Feature;

use ali\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class resetPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_see_reset_password_request_form()
    {
        $response = $this->get(route('password.request'));
        $response->assertOk();

    }

//    public function test_user_can_enter_verify_code_form_by_correct_email()
//    {
//
//
//
//        $this->call('get',
//            route('password.sendVerifyCodeEmail'),
//            ['email' => 'agholamnezhad69@gmail.com'])
//            ->assertOk();
//
//
//    }
    public function test_user_can_enter_verify_code_form_by_correct_mobile()
    {

        $this->post(route('register'), [
            'mobile' => '09372999531',
            'password' => '123456',
            'password_confirmation' => '123456',
        ]);

        $this->assertEquals(1, User::query()->count());

        $this->call('get',
            route('password.sendVerifyCodeEmail'),
            ['mobile' => '09372999531'])
            ->assertOk();


    }

    public function test_user_can_enter_verify_code_form_by_wrong_email()
    {
        $this->call('get', route('password.sendVerifyCodeEmail'), ['email' => 'agholamnezhad69.gmail.com'])
            ->assertStatus(302);


    }


    public function test_user_banned_after_6_attempt_to_reset_password()
    {
        for ($i = 1; $i <= 5; $i++) {

            $this->post(route('password.checkVerifyCode'), ['verify_code', 'email' => 'agholamnezhad69@gmail.com'])
                ->assertStatus(302);

        }

        $this->post(route('password.checkVerifyCode'), ['verify_code', 'email' => 'agholamnezhad69@gmail.com'])
            ->assertStatus(429);


    }


}
