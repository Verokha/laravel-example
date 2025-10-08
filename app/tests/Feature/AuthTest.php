<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function test_create_user_success():void
    {
        //$requestData = ['name'=> 'Ivan', 'email'=> 'ivan@mail.ru', 'password'=> '123pass'];
        $newUser = User::factory()->make();
        $response = $this
            ->post('api/register',['name'=> $newUser->name, 'email'=> $newUser->email, 'password'=> $newUser->password]);
        $response->assertStatus(201);
        $response->assertJsonStructure(['user', 'token']);
    }
    public function test_auth_user_success():void
    {
        $newUser = User::factory()->create();
        $response = $this
            ->post('api/login',['email'=>$newUser->email, 'password'=>'password']);
        $response->assertStatus(200);
        $response->assertJsonStructure(['token']);
    }
    public function test_get_user():void //проверить данные по имени и почте тот ли юзер
    {
        $newUser = User::factory()->create();
        $response = $this
            ->get('api/user',['email'=>$newUser->email, 'password'=>'password']);
        $response->assertStatus(200);
    }
    public function test_logout_user():void //проверка статуса и месседж
    {
        $newUser = User::factory()->create();
        $response = $this
            ->post('api/login',['email'=>$newUser->email, 'password'=>'password']);
        $response->assertStatus(200);
        $response = $this
            ->post('api/logout',['email'=>$newUser->email, 'password'=>'password']);
        $response->assertStatus(200);
        $response->assertJsonStructure(['message']); //или через $responseData = ['message'=> 'такой то'];

    }
    
}
