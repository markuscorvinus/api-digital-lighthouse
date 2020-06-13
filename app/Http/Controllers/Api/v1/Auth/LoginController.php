<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use ThrottlesLogins;
    
    private $loginThrough = 'email';

    public function login(Request $request)
    {   
        $this->validateLogin($request);
        
        /* if (Auth::attempt($request->only(['email', 'password']))) {
            return response(["success" => true], 200);
        } else {
            return response(["success" => false], 403);
        } */
        if ($this->guard()->attempt($request->only($this->username(), 'password'), $request->filled('remember'))) {
            return response(["success" => true], 200);
        } else {
            return response(["success" => false], 403);
        }
    }


    protected function validateLogin(Request $request)
    {   
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);        
    }

    /** primary login to be used by the user */
    public function username()
    {
        return $this->loginThrough;
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
