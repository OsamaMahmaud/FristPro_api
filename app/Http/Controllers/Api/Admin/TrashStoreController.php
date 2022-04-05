<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrashStore;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;


class TrashStoreController extends Controller
{
    use GeneralTrait;
    public function index()
    {
        # code...
        $emp = TrashStore::all();
        return $this->sendResponse($emp->toArray(), 'All Store');
    }

    public function store(Request $request)
    {
        # code...
        $input = $request->all();
        $emp = Validator::make($input, [
            'name'=> 'required',
            'category_name'=> 'required',
            'quantity'=>'required',
            'location'  =>'required',
        ] );

        if ($emp->fails()) {
            $code = $this->returnCodeAccordingToInput($emp);
            return $this->returnValidationError($code, $emp);
        }

        $emp = TrashStore::create($input);
        return $this->sendResponse($emp->toArray(), 'Store  created succesfully');

    }

    public function show(  $id)
    {
        $emp = TrashStore::find($id);
        if (   is_null($emp)   ) {
            # code...
            return $this->sendError(  '$Store not found ! ');
        }
        return $this->sendResponse($emp->toArray(), 'show Store succesfully');

    }



// update employee
    public function update(Request $request , $id)
    {
        $emp=TrashStore::find($id);
        $input = $request->all();
        $validator = Validator::make($input, [
            'name'=> 'required',
            'category_name'=> 'required',
            'quantity'=>'required',
            'location'  =>'required',
        ] );

        if ($validator -> fails()) {
            # code...
            return $this->sendError('error validation', $validator->errors());
        }
        $emp->name =  $input['name'];
        $emp->category_name =  $input['category_name'];
        $emp->location =  $input['location'];
        $emp->quantity =  $input['quantity'];
        $emp->save();
        return $this->sendResponse($emp->toArray(), 'Store  updated succesfully');

    }


// delete employee
    // public function destroy(AddEmployee $emp)
    // {


    //     $emp->delete();

    //     return $this->sendResponse($emp->toArray(), 'employee  deleted succesfully');

    // }

    public function destroy(Request $request, $id)
    {


        $emp=TrashStore::find($id);
        $emp->delete();


        return $this->sendResponse($emp->toArray(), 'Store  deleted succesfully');

    }



}
