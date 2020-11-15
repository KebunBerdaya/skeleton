<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Post;
use App\Thread;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request){
        if(Auth::attempt(['username' => $username , 'password' => $password]))
        {
            //return 200 status as json and auth as user
            return response()->json(Auth::user(), 200);
        }
        else
        {
            return response()->json(['error' => 401],200);
        }
    }
        public function register(Request $request)
        {
            //check username exist or not
            $user = User::where('username',$request->username)->first();
            if(isset($user->username))
            {
                return response()->json(['username_taken' => 401],200);
            }
            // then we create the user
            $user = new User();
            $user->name = $request->name;
            $user->username = $request->username;
            $user->password = bcrypt($request->password);
            $user->save();
            //log them in
            Auth::login($user);

            return response()->json($user,200);

        }
    
}
