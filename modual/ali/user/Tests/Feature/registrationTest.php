<?php

namespace ali\user\Tests\Feature;

use ali\user\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class registrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_see_register_form()
    {
        $response = $this->get(route('register'));
        $response->assertStatus(200);
    }

    public function test_user_can_register()
    {
        $this->withoutExceptionHandling();

        $response = $this->register_new_user();

        $response->assertRedirect(route('home'));


        $this->assertCount(1, User::all());

    }

    public function test_user_must_verify_account()
    {


        $this->register_new_user();

        $response = $this->get(route('home'));

        $response->assertRedirect(route('verification.notice'));


    }

    public function test_user_can_see_home_page()
    {

        $this->register_new_user();
        $this->assertAuthenticated();

        auth()->user()->markEmailAsVerified();

        $response = $this->get(route('home'));

        $response->assertOk();


    }

    public function register_new_user()
    {


        return $this->post(route('register'), [
            'name' => 'ali',
            'email' => 'agholamnezhad69111@gmail.com',
            'mobile' => '9392001801',
            'password' => 'aA!li123',
            'password_confirmation' => 'aA!li123',
        ]);


    }


}
