<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;

class ProfileController extends Controller
{
    use GeneralTrait;
    public function index()
    {
        # code...
        $profile = Profile::all();
        return $this->sendResponse($profile->toArray(), 'profile  succesfully');
    }

    public function store(Request $request)
    {
        # code...
        $input = $request->all();
        $validator =    Validator::make($input, [
            'name'=> 'required',
            'email'=>'required',
            'password'=> 'required'
        ] );

        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }

        $profile = Profile::create($input);
        return $this->sendResponse($profile->toArray(), 'Profile  created succesfully');

    }

    public function show(  $id)
    {
        $profile = Profile::find($id);
        if (   is_null($profile)   ) {
            # code...
            return $this->sendError(  '$profile not found ! ');
        }
        return $this->sendResponse($profile->toArray(), 'profile succesfully');

    }



// update book
    public function update(Request $request , Profile $profile)
    {
        $input = $request->all();
        $validator =    Validator::make($input, [
            'name'=> 'required',
            'email'=> 'required',
            'password'=> 'required'
        ] );

        if ($validator -> fails()) {
            # code...
            return $this->sendError('error validation', $validator->errors());
        }
        $profile->name =  $input['name'];
        $profile->email =  $input['email'];
        $profile->password =  $input['password'];
        $profile->save();
        return $this->sendResponse($profile->toArray(), 'profile  updated succesfully');

    }

// delete book
    public function destroy(Profile $profile)
    {

        $profile->delete();

        return $this->sendResponse($profile->toArray(), 'profile  deleted succesfully');

    }

}
