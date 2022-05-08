<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Factory;
use App\Models\Category;
use App\Models\Fact_Category;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;



class FactoryController extends Controller
{

    use GeneralTrait;

    public function index()
    {
        $factory = Factory::first();

        return $this->sendResponse($factory->toArray(), 'All Factory');

    }

    public function getdepartment()
    {

        $dept=Department::get();
        return $this->sendResponse($dept->toArray(), '  get all department succesfully');
    }


    public function store(Request $request)
    {
        # code...
        $input = $request->all();
     //   $employee_name = $request->employee_name;
        $validator = Validator::make($input, [
            'factory_name'=> 'required',
            'contact_num'=> 'required',
            'factory_location'=> 'required',
            'category_id'=>'required'
        ] );



        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }

        $factor = Factory::create($input);

        return $this->sendResponse($factor->toArray(), 'Factory  created succesfully');

    }



    public function show( $id)
    {
        $factor = Factory::find($id);
        if (   is_null($factor)   ) {
            # code...
            return $this->sendError(  '$factor not found ! ');
        }
        return $this->sendResponse($factor->toArray(), 'show Factory succesfully');
    }

// update category
    public function update(Request $request ,  $id)
    {
        $factor=Factory::find($id);
        $input = $request->all();
        $validator = Validator::make($input, [
            'factory_name'=> 'required',
            'contact_num'=> 'required',
            'factory_location'=> 'required',
            'category_id'=>'required'
        ] );

        if ($validator -> fails()) {
            # code...
            return $this->sendError('error validation', $validator->errors());
        }
        $factor->factory_name =  $input['factory_name'];
        $factor->contact_num =  $input['contact_num'];
        $factor->factory_location = $input['factory_location'];
        $factor->category_id = $input['category_id'];
        $factor->save();
        return $this->sendResponse($factor->toArray(), 'Factory  updated succesfully');
    }

    public function destroy(Request $request, $id)
    {
        $factor=Factory::find($id);
        $factor->delete();
        return $this->sendResponse($factor->toArray(),'factor  deleted succesfully');
    }

    public function getAllCategory(){
        $category=Category::get();
        return $this->sendResponse($category->toArray(),'factor  deleted succesfully');

    }


}
