<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\AddEmployee;
use App\Models\Admin;
use App\Models\Car;
use App\Models\Department;
use App\Models\Employee;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;



class CarController extends Controller
{

    use GeneralTrait;
    public function index()
    {
        # code...
        // $car = Car::all();
        // return $this->sendResponse($car->toArray(), 'All Cars');

        $car = Car::first();
        $car = Car::get();
        // $car =Car::with('employee')->get();
        $emp=AddEmployee::select('dept_id')->get();
        // $dep=Department:get();
        // $emp = $admin->employee;
        return $this->sendResponse($car->toArray(), 'All Employees');
    }

    public function store(Request $request)
    {
        # code...
        $input = $request->all();
        $validator = Validator::make($input, [
            'drivers_name'=> 'required',
        ] );

        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }
        $car = Car::create($input);

        return $this->sendResponse($car->toArray(), 'Car created succesfully');

    }

    public function show($id)
    {
        $car = Car::find($id);
        if (   is_null($car)   ) {
            # code...
            return $this->sendError(  '$Car not found ! ');
        }
        return $this->sendResponse($car->toArray(), 'show Car succesfully');
    }

// update category
    public function update(Request $request , Car $car)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'drivers_name'=> 'required',
        ]);
        
        if ($validator -> fails()) {
            # code...
            return $this->sendError('error validation', $validator->errors());
        }
        $car->drivers_name =  $input['drivers_name'];

        $car->save();
        return $this->sendResponse($car->toArray(), 'car  updated succesfully');

    }

// delete category
    public function destroy(Car $car)
    {
        $car->delete();
        return $this->sendResponse($car->toArray(), 'Car  deleted succesfully');
    }

    public function getDeptOfCar()
    {
        $emp=Admin::whereHas('department', function ($q) {
            $q->where('dept_name', 'deriver');
        })->get('name');
        return $this->sendResponse($emp->toArray(), ' get derivers succesfully');
    }
}



