<?php

namespace Tests\Feature;

use Tests\TestCase;

class UserTest extends TestCase
{
    public function testRegisterSuccess()
    {
        $this->post('/api/users', [
            'username' => 'anharsaja',
            'password' => 'asdjkl',
            'name' => 'anhar'
        ])->assertStatus(201)
            ->assertJson([
                "data" => [
                    "username" => "anharsaja",
                    "name" => "anhar"
                ]
            ]);
    }

    public function testRegisterFailed()
    {
        $this->post('/api/users', [
            'username' => '',
            'password' => '',
            'name' => ''
        ])->assertStatus(400)
            ->assertJson([
                "errors" => [
                    "username" => [
                        "The username field is required."
                    ],
                    "name" => [
                        "The name field is required."
                    ],
                    "password" => [
                        "The password field is required."
                    ]
                ]
            ]);
    }

    public function testRegisterUsernameAlreadyExists()
    {
        $this->testRegisterSuccess();
        $this->post('/api/users', [
            'username' => 'anharsaja',
            'password' => 'asdjkl',
            'name' => 'anhar'
        ])->assertStatus(400)
            ->assertJson([
                "errors" => [
                    "username" => [
                        "The username has already been taken."
                    ]
                ]
            ]);
    }
}
