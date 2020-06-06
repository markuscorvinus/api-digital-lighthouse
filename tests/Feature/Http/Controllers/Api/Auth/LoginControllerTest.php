<?php

namespace Tests\Feature\Http\Controllers\Api\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
   /** @test **/
   public function user_can_login()
   {    
        //$this->withoutExceptionHandling();

        //register first
        $response = $this->withHeaders([
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
        
        //attempt to login
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest'
        ])->json('POST',route('login'), [
            'email' => 'mcorvinus@admin.com',
            'password' => 'password',
        ]);
        
        $response->assertStatus(200);
        $response->assertOk();

   }
}
