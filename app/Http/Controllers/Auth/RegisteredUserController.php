<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    public function __construct()
    {
        
    }

    public function register(Request $request)
    {
        // Validate the credentials
        $request->validate([

            "name" => 'required|string',

            // Unique to the users table in the email column
            'email' => 'required|string',
        
            // password_confirmed need to be sent as well
            'password' => 'required|string'
        ]);

        $user = new User();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));

        Log::info($user);

        if ($user->save()){
            return response()->json([
                'status' => 'success',
                'message' => "Account created successfully",
                'user' => $user
            ], 200);
        }
        else {
            return response()->json([
                'status' => 'failure',
                'message' => "There was a problem creating the account",
            ], 401);
        }

        
    }
}
