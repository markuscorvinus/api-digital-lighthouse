<?php

namespace Tests\Feature\Http\Controllers\Api\Auth;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{  
    use RefreshDatabase;

    public function setUp():void
    {
        parent::setUp();

        $this->withHeaders([
            'Accept' => 'application/json',
            'HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest'
        ])->json('POST',route('register'), [
            'first_name' => 'Markus',
            'last_name' => 'Corvinus',
            'email' => 'mcorvinus@admin.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'system_user_type' => 2,
            'created_user_id' => 1,
            'updated_user_id' => 1,
        ]);
    }


    /** @test **/
    public function user_can_login()
    {   
        // attempt to login (X-XSRF-TOKEN is required in login headers)
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest',
            'X-XSRF-TOKEN' => 'eyJpdiI6IkhoRnNoYWNTU3JaS01ma3BDQ0hyT0E9PSIsInZhbHVlIjoiZjZkYmIwUjA3anJ0RmlianM5SmpJNzllVFA0MnR0bWFQQXhYZXpyYVBQb1UzUzhPRVBzWi90L1FvbXdRQnpubSIsIm1hYyI6ImQwZTZmZDRiYzZlZTU5YTQxNjQ0NzkxMzg2ZDVlMmQyMzM5MTFmYzdkZWM5ODAyMWRkZTYzNzE5ZmYxMjI0NzQifQ=='
        ])->json('POST',route('login'), [
            'email' => 'mcorvinus@admin.com',
            'password' => 'password',
        ]);
        //dd($response->content);
        $response->assertStatus(200);
        $response->assertOk();
        $response->assertJson(["status" => "success"]);

    }

    /** @test **/
    public function throws_an_error_if_authentication_failed()
    {    
        // attempt to login (X-XSRF-TOKEN is required in login headers)
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest',
            'X-XSRF-TOKEN' => 'eyJpdiI6IkhoRnNoYWNTU3JaS01ma3BDQ0hyT0E9PSIsInZhbHVlIjoiZjZkYmIwUjA3anJ0RmlianM5SmpJNzllVFA0MnR0bWFQQXhYZXpyYVBQb1UzUzhPRVBzWi90L1FvbXdRQnpubSIsIm1hYyI6ImQwZTZmZDRiYzZlZTU5YTQxNjQ0NzkxMzg2ZDVlMmQyMzM5MTFmYzdkZWM5ODAyMWRkZTYzNzE5ZmYxMjI0NzQifQ=='
        ])->json('POST',route('login'), [
            'email' => 'mcorvinus@admin.com',
            'password' => 'password123',
        ]);
        //dd($response->content);
        $response->assertStatus(401);
        $response->assertJson(["status" => "failed"]);
            
    }
}
