<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserManagement\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RegisterController extends Controller
{   
    public function __construct()
    {
        //$this->middleware('guest');
    }


    public function register(Request $request)
    {   
        $validateData = $this->validateRequest();
        
        event(new Registered($user = $this->create($validateData)));
        
        return $request->wantsJson()
                    ? new Response(['message' => 'Successfully created user!'], 201)
                    : redirect($this->redirectPath());
    }
    
    
    protected function validateRequest()
    {   
        return request()->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'system_user_type' => ['required', 'numeric'],
        ]);
    }

    
    protected function create(array $data)
    {   
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'full_name' => $data['first_name'] . ' ' . $data['last_name'],
            'email' => $data['email'],
            'password' => $data['password'], 
            'system_user_type' => $data['system_user_type'],
            'created_user_id' => 1,
            'updated_user_id' => 1,
        ]);
    }    
    
}
