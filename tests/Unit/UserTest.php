<?php

namespace Tests\Unit;

use App\Models\UserManagement\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{   
    use RefreshDatabase;
    use WithFaker;

    /** @test **/
    public function can_create_default_user()
    {   
        $fname = $this->faker()->firstName();
        $lname = $this->faker()->lastName();
        
        User::create([
            'first_name' => $fname,
            'last_name' => $lname,
            'full_name' => $fname . " " . $lname,
            'email' => $this->faker()->safeEmail,
            'password' => 'Password',
            'system_user_type' => 3,
            'created_user_id' => 1,
            'updated_user_id' => 1,
        ]);

        $this->assertCount(1, User::all());
        $this->assertDatabaseHas('users', [
            'first_name' => $fname,
            'last_name' => $lname,
            'full_name' => $fname . " " . $lname,
        ]);
    }


    /** @test **/
    public function can_create_approve_other_user()
    {   
        $fname = $this->faker()->firstName();
        $lname = $this->faker()->lastName();
        
        //create user
        $user = User::create([
            'first_name' => $fname,
            'last_name' => $lname,
            'full_name' => $fname . " " . $lname,
            'email' => $this->faker()->safeEmail,
            'password' => 'Password',
            'system_user_type' => 3,
            'created_user_id' => 1,
            'updated_user_id' => 1,
        ]);
        
        //create admin
        $admin = User::create([
            'first_name' => 'System',
            'last_name' => 'Administrator',
            'full_name' => 'System Administrator',
            'email' => $this->faker()->safeEmail,
            'password' => 'Password',
            'system_user_type' => 2,
            'created_user_id' => 1,
            'updated_user_id' => 1,
        ]);
        
        $admin->approvedUser($user);

        $this->assertCount(2, User::all());
        $this->assertEquals(true, User::first()->is_active);
    }
}
