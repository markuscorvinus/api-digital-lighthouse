<?php

namespace Tests\Feature\Http\Controllers\Api\Auth;

use App\Models\UserManagement\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{   
    use WithFaker, RefreshDatabase;
    
    /** @test **/
    public function can_register_regular_user()
    {   
        $fname = $this->faker()->firstName();
        $lname = $this->faker()->lastName();

        $response = $this->withHeaders([
                'Accept' => 'application/json',
                'HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest'
            ])->json('POST',route('register'), [
             'first_name' => $fname,
             'last_name' => $lname,
             'email' => $this->faker()->safeEmail,
             'password' => 'password',
             'password_confirmation' => 'password',
             'system_user_type' => 3,
             'created_user_id' => 1,
             'updated_user_id' => 1,
        ]);
        
        $response->assertStatus(201);
        $this->assertArrayHasKey('message',$response);
        
    }


    /** @test **/
    public function existing_email_throw_error()
    {   
        //$this->withoutExceptionHandling();

        $fname = $this->faker()->firstName();
        $lname = $this->faker()->lastName();

        //initial request
        $this->withHeaders([
                'Accept' => 'application/json',
                'HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest'
            ])->json('POST',route('register'), [
             'first_name' => $fname,
             'last_name' => $lname,
             'email' => 'exist123@admin.com',
             'password' => 'password',
             'password_confirmation' => 'password',
             'system_user_type' => 3,
             'created_user_id' => 1,
             'updated_user_id' => 1,
        ]);
        
        $fname = $this->faker()->firstName();
        $lname = $this->faker()->lastName();
        
        //duplicate email
        $response =$this->withHeaders([
                'Accept' => 'application/json',
                'HTTP_X_REQUESTED_WITH' => 'XMLHttpRequest'
            ])->json('POST',route('register'), [
                'first_name' => $fname,
                'last_name' => $lname,
                'email' => 'exist123@admin.com',
                'password' => 'password',
                'password_confirmation' => 'password',
                'system_user_type' => 3,
                'created_user_id' => 1,
                'updated_user_id' => 1,
            ]);
        
        $user = User::all();
        
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
        $this->assertCount(1, $user);
    }
}
