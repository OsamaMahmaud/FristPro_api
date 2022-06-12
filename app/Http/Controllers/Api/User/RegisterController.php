<?php

namespace App\Http\Controllers\Api\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\GeneralTrait;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;

class RegisterController extends Controller
{
    use GeneralTrait;

    public function register( Request $request){
        $validator = Validator::make($request -> all(),[
            'email' => 'required|string|email|max:255|unique:users',
            'name' => 'required',
            'ssn' => 'required',
            'password'=> 'required',
            'photo'=> 'required'

        ]);

        if ($validator -> fails()) {
            # code...
            return response()->json($validator->errors());
        }

        $file_name = $this->saveImage($request->photo, 'images');

        User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'ssn'=> $request->get('ssn'),
            'password'=> bcrypt($request->get('password')),
            'photo'=>  $file_name
        ]);
        $user = User::first();
        $token = JWTAuth::fromUser($user);

        return Response::json( compact('token'));


    }
}
