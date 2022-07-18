<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['logout']);
    }

    public function login(Request $request){

        // Validate the credentials
        $credentials = $request->validate([
            // Unique to the users table in the email column
            'email' => 'required|string',
        
            // password_confirmed need to be sent as well
            'password' => 'required|string'
        ]);

        // Attempt to login
        if (Auth::attempt($credentials)){

            // Create user's session
            $request->session()->regenerate();
            return redirect('/dashboard');
        }

        return response()->json([
            'message' => "Bad Credentials",
        ], 401);

        // return response([
        //     'message' => "Bad Credentials",
        // ], 401);
    }

    public function logout(Request $request){

        // Logout
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
