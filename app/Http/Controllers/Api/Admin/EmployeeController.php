<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\AddEmployee;
use App\Models\Department;
use App\Models\Admin;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;

class EmployeeController extends Controller
{
    use GeneralTrait;
    /* Start get List Of department */
    public function getdepartment()
    {

        $dept=Department::get();
        return $this->sendResponse($dept->toArray(), '  get all department succesfully');
    }
    /* End get List Of department */

    public function index()
    {
        $admin = Admin::first();
        $admin = Admin::with('employee')->find(6);
        $emp = $admin->employee;
        return $this->sendResponse($emp->toArray(), 'All Employees');
    }

    public function store(Request $request)
    {
        # code...
        $input = $request->all();
        $validator = Validator::make($input, [
            'name'=> 'required',
            'address'=> 'required',
            'email'=>'required',
            'password'=>'required',
            'dept_id'=>'required'
        ] );

        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }
        $emp = AddEmployee::create($input);
        return $this->sendResponse($emp->toArray(), 'Employee created succesfully');
    }

// update employee
    public function update(Request $request , $id)
    {
        $emp=AddEmployee::find($id);
        $input = $request->all();
        $validator = Validator::make($input, [
            'name'=> 'required',
            'address'=> 'required',
            'email'=>'required',
            'password'=>'required',
            'dept_id'=>'required'
        ]);
        if ($validator -> fails()) {
            # code...
            return $this->sendError('error validation', $validator->errors());
        }
        $emp->name =  $input['name'];
        $emp->address =  $input['address'];
        $emp->email =  $input['email'];
        $emp->password =  $input['password'];
        $emp->save();
        return $this->sendResponse($emp->toArray(), 'employee  updated succesfully');
    }

    public function destroy(Request $request, $id)
    {
        $emp=AddEmployee::find($id);
        $emp->delete();
        return $this->sendResponse($emp->toArray(), 'employee  deleted succesfully');
    }
    
}
