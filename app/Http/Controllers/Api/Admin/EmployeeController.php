<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\AddEmployee;
use App\Models\Role;
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

    public function getdepartment()
    {

        $dept=Department::get();
        return $this->sendResponse($dept->toArray(), '  get all department succesfully');
    }


    public function index()
    {
        $admin = Admin::first();
        // $admin = Admin::with('employee')->find(6);
        $admin = Admin::get();
        // $emp = $admin->employee;
        return $this->sendResponse($admin->toArray(), 'All Employees');
    }

    public function create(){
        $roles = Role::get();
        return $this->sendResponse($roles->toArray(), ' all admins  succesfully');

     //    return view('dashboard.users.create',compact('roles'));
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
            'dept_id'=>'required',
            'role_id'=>'required'
        ] );

        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }
        $emp = Admin::create($input);
        return $this->sendResponse($emp->toArray(), 'Employee created succesfully');
    }

// update emp
    public function update(Request $request , $id)
    {
        $emp=Admin::find($id);
        $input = $request->all();
        $validator = Validator::make($input, [
            'name'=> 'required',
            'address'=> 'required',
            'email'=>'required',
            'password'=>'required',
            'dept_id'=>'required',
            'role_id'=>'required'
        ]);
        if ($validator -> fails()) {
            # code...
            return $this->sendError('error validation', $validator->errors());
        }
        $emp->name =  $input['name'];
        $emp->address =  $input['address'];
        $emp->email =  $input['email'];
        $emp->password =  $input['password'];
        $emp->role_id =  $input['role_id'];
        $emp->save();
        return $this->sendResponse($emp->toArray(), 'employee  updated succesfully');
    }

    ////delet emp
    public function destroy(Request $request, $id)
    {
        $emp=Admin::find($id);
        $emp->delete();
        return $this->sendResponse($emp->toArray(), 'employee  deleted succesfully');
    }

}
