<?php

namespace ali\User\Tests\Feature;

use ali\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{

    use WithFaker;

   use RefreshDatabase;

//    public function test_user_can_login_by_email()
//    {
//        $user = User::create(
//            [
//                'name' => $this->faker->name,
//                'email' => $this->faker->safeEmail,
//                'password' => bcrypt("aA12!@ali")
//            ]
//        );
//
//        $this->post(route('login'), [
//            'email' => $user->email,
//            'password' => "aA12!@ali",
//
//        ]);
//
//        $this->assertAuthenticated();
//
//    }
   public function test_user_can_login_by_mobile()
      {
          $user = User::create(
              [
                  'name' => $this->faker->name,
                  'email' => $this->faker->safeEmail,
                  'mobile' => '09372999531',
                  'password' => bcrypt("aA12!@ali")
              ]
          );

          $this->post(route('login'), [
              'email' => $user->mobile,
              'password' => "aA12!@ali",

          ]);

          $this->assertAuthenticated();

      }
}
