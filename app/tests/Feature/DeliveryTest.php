<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class DeliveryTests extends TestCase
{
    public function test_make_order() : void 
    {
        $this
            ->post('api/register',['name'=>'Иван', 'email'=> 'ivan@mail.ru', 'password'=> 'password']);
        $response = $this
            ->post('api/login',['email'=>'ivan@mail.ru', 'password'=>'password']);
        $responseData = $response->json();
    }
}