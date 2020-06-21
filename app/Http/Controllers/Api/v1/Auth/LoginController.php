<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ResponseBuilder;

class LoginController extends Controller
{
    use ThrottlesLogins;
    
    private $loginThrough = 'email';

    public function login(Request $request)
    {   
        /* if(!$request->secure()){
            return response(["success" => false, "message" => "Invalid Request! Request must be secure" ], 403);
        } */
        $this->validateLogin($request);
        
        if ($this->guard()->attempt($request->only($this->username(), 'password'), $request->filled('remember'))) {
            $user = Auth::user();
            return response()->json(ResponseBuilder::generate_response("success",200,"Login successful!", $user->only(['id','full_name'])), 200);
        } else {
            return response(ResponseBuilder::generate_response("failed",401,"Incorrect username or password"), 401);
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
