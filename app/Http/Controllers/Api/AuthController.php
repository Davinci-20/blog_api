<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelpers;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name'=>'required|max:30',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6,max:20'
        ]);

        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]);
$token = $user->createToken('Blog')->accessToken;
        return ResponseHelpers::success([
            'access_token'=>$token
        ]);
}

public function login(Request $request){
    $request->validate([
        'email'=>'required|email',
        'password'=>'required',
    ]);

    if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
        $user=Auth::user();
        $token = $user->createToken('Blog')->accessToken;
        return ResponseHelpers::success([
            'access_token'=>$token
        ]);
    }
}

public function logout(){
    Auth::user()->token()->revoke();
    return ResponseHelpers::success([],'Successful Logout!');
}
}