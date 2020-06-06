<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class LoginController extends Controller
{
    use ThrottlesLogins;
    
    private $loginThrough = 'email';

    public function login(Request $request)
    {   
        $this->validateLogin($request);

        if ($this->guard()->attempt($this->credentials($request), $request->filled('remember'))) {
            return $this->sendLoginResponse($request);
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
}
