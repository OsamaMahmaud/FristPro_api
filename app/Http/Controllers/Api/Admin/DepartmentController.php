<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;



class DepartmentController extends Controller
{
   //All category
    use GeneralTrait;
    public function index()
    {
        # code...
        $profile = Department::all();
        return $this->sendResponse($profile->toArray(), 'All Department');

    }

    //post category
    public function store(Request $request)
    {
        # code...
        $input = $request->all();
        $validator = Validator::make($input, [
            'name'=> 'required',

        ] );

        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }

        $profile = Department::create($input);
        return $this->sendResponse($profile->toArray(), 'Department  created succesfully');

    }

    //show category
    public function show(  $id)
    {
        $profile = Department::find($id);
        if (   is_null($profile)   ) {
            # code...
            return $this->sendError(  'Department not found ! ');
        }
        return $this->sendResponse($profile->toArray(), 'show Department succesfully');

    }



// update category
    public function update(Request $request , Department $profile)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name'=> 'required',
        ] );

        if ($validator -> fails()) {
            # code...
            return $this->sendError('error validation', $validator->errors());
        }
        $profile->name =  $input['name'];
        $profile->save();
        return $this->sendResponse($profile->toArray(), 'Department  updated succesfully');

    }

// delete category
    public function destroy(Department $profile)
    {
        $profile->delete();
        return $this->sendResponse($profile->toArray(), 'Department  deleted succesfully');

    }

}
