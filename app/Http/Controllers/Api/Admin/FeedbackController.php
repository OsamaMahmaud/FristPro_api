<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\AddEmployee;
use App\Models\Feedback;
use App\Models\Department;
use App\Models\Employee;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;



class FeedbackController extends Controller
{

    use GeneralTrait;
    public function index()
    {


        $feedback = Feedback::get();

        return $this->sendResponse($feedback->toArray(), 'All feedback');
    }

    public function store(Request $request)
    {
        # code...
        $input = $request->all();
        $validator = Validator::make($input, [
            'name'=> 'required',
            'ssn'=> 'required',
            'feedback'=> 'required',
        ] );

        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }
        $feedback = Feedback::create($input);

        return $this->sendResponse($feedback->toArray(), 'feedback created succesfully');

    }

    public function show(  $id)
    {
        $feedback = Feedback::find($id);
        if (   is_null($feedback)   ) {
            # code...
            return $this->sendError(  '$feedback not found ! ');
        }
        return $this->sendResponse($feedback->toArray(), 'show feedback succesfully');

    }

// update feedback
    public function update(Request $request , Feedback $feedback)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name'=> 'required',
            'ssn'=> 'required',
            'feadback'=> 'required',
        ]);

        if ($validator -> fails()) {
            # code...
            return $this->sendError('error validation', $validator->errors());
        }
        $feedback->name =  $input['name'];
        $feedback->snn =  $input['snn'];
        // $feedback->phone =  $input['phone'];
        $feedback->feedback =  $input['feedback'];
        $feedback->save();
        return $this->sendResponse($feedback->toArray(), 'feedback  updated succesfully');

    }

// delete feedback
    public function destroy(Feedback $feedback)
    {
        $feedback->delete();
        return $this->sendResponse($feedback->toArray(), 'feedback  deleted succesfully');
    }


}



