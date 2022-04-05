<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Addarea;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;



class AddareaController extends Controller
{

    use GeneralTrait;
    public function index()
    {
        # code...
        $addarea = Addarea::all();
        return $this->sendResponse($addarea->toArray(), 'All area');
    }

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

        $addarea = Addarea::create($input);
        return $this->sendResponse($addarea->toArray(), 'Area created succesfully');

    }

    public function show(  $id)
    {
        $area = Addarea::find($id);
        if (   is_null($area)   ) {
            # code...
            return $this->sendError(  'area not found ! ');
        }
        return $this->sendResponse($area->toArray(), 'show area succesfully');

    }



// update category
    public function update(Request $request , Addarea $area)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name'=> 'required',

        ] );

        if ($validator -> fails()) {
            # code...
            return $this->sendError('error validation', $validator->errors());
        }
        $area->name =  $input['name'];
        $area->save();
        return $this->sendResponse($area->toArray(), 'area  updated succesfully');

    }

// delete category
    public function destroy(Addarea $area)
    {
        $area->delete();
        return $this->sendResponse($area->toArray(), 'Car  deleted succesfully');

    }

}
