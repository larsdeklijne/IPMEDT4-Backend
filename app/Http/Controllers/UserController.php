<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;

use Illuminate\Support\Facades\Auth;

use Validator, Input, Redirect, Hash;

use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use \Illuminate\Foundation\Auth\AuthenticatesUsers;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\PayloadFactory;
use Tymon\JWTAuth\JWTManager as JWT;

class UserController extends Controller
{

    public function register($name, $email, $password)
    {

        $requestRegister = array(
            'name' => $name,
            'email' => $email,
            'password' => $password);

        json_encode($requestRegister);

        $validator = Validator::make($requestRegister, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'name' => htmlentities($name),
            'email' => htmlentities($email),
            'password' => htmlentities($password),
        ]);


        return response()->json(compact('user'), 201);

        $user -> save();

    }

    public function login($email, $password)
    {
        if
        (
            User::where([
            ['email',  '=', $email],
            ['password', '=', $password],
            ])->exists()
        ) {
            return "true";
        } else {
            return "false";
        };



    }


}

