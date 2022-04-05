<?php

namespace App\Http\Controllers\Api\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;



class RegisterController extends Controller
{
    //
    public function register( Request $request){
        $validator = Validator::make($request -> all(),[
            'email' => 'required|string|email|max:255|unique:admins',
            'name' => 'required|string',
            'password'=> 'required|string|confirmed|min:6'
        ]);

        if ($validator -> fails()) {
            # code...
            return response()->json($validator->errors(),400);
        }

        Admin::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password'=> bcrypt($request->get('password')),
        ]);
        $admin = Admin::first();
        $token = JWTAuth::fromUser($admin);

        return Response::json( compact('token'));


    }
}
