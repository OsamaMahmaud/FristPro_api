<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\bills;
use App\Models\Admin;
use App\Models\Car;
use App\Models\Supplies;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;



class BillController extends Controller
{

    use GeneralTrait;

    public function index()
    {
        $bill = bills::get();
        return $this->sendResponse($bill->toArray(), 'All bill');
    }


    public function store(Request $request)
    {
        # code...
        $input = $request->all();
        $validator = Validator::make($input, [
            'acco_name'=> 'required',
            'car_num'=> 'required',
            'area'=> 'required',
            // 'created_at'=>'required'
        ] );



        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }

        $bill = bills::create($input);

        return $this->sendResponse($bill->toArray(), 'bill  created succesfully');

    }



    public function show( $id)
    {
        $factor = bills::find($id);
        if (   is_null($factor)   ) {
            # code...
            return $this->sendError(  '$factor not found ! ');
        }
        return $this->sendResponse($factor->toArray(), 'show Factory succesfully');
    }

// update facrory
    public function update(Request $request ,  $id)
    {
        $bill=bills::find($id);
        $input = $request->all();
        $validator = Validator::make($input, [
            'acco_name'=> 'required',
            'car_num'=> 'required',
            'area'=> 'required',
            // 'created_at'=>'required'
        ] );

        if ($validator -> fails()) {
            # code...
            return $this->sendError('error validation', $validator->errors());
        }
        $bill->acco_name =  $input['acco_name'];
        $bill->car_num =  $input['car_num'];
        $bill->area = $input['area'];
        // $bill->created_at = $input['created_at'];
        $bill->save();
        return $this->sendResponse($bill->toArray(), 'bill  updated succesfully');
    }

    public function destroy(Request $request, $id)
    {
        $bill=bills::find($id);
        $bill->delete();
        return $this->sendResponse($bill->toArray(),'bill  deleted succesfully');
    }

    // public function getAllCategory(){
    //     $category=Category::get();
    //     return $this->sendResponse($category->toArray(),'factor  deleted succesfully');

    // }


    public function getderivers()
    {
        $emp=Admin::whereHas('department', function ($q) {
            $q->where('dept_name', 'deriver');
        })->get('name');
        return $this->sendResponse($emp->toArray(), ' get derivers succesfully');
    }


    public function getAccoName()
    {
        $emp=Admin::whereHas('department', function ($q) {
            $q->where('dept_name', 'accountant');
        })->get('name');
        return $this->sendResponse($emp->toArray(), ' get accountant succesfully');
    }

    public function getCarId()
    {
        $emp=car::get('id');
        return $this->sendResponse($emp->toArray(), ' get Car_id  succesfully');
    }


    public function getallquantity()
    {
        $metal=Supplies::where('category','metal')->sum('quantity');
        // return $metal;
        $plastic=Supplies::where('category','plastic')->sum('quantity');
        $pepar=Supplies::where('category','pepar')->sum('quantity');
        return compact('metal','plastic','pepar');
    }


    public function getquantityofbill($bill_id)
    {

        $bill=bills::where('id',$bill_id)->get();
        $metal=Supplies::where('category','metal')->where('bill_id',$bill_id)->sum('quantity');
        $paper=Supplies::where('category','pepar')->where('bill_id',$bill_id)->sum('quantity');
        $plastic=Supplies::where('category','plastic')->where('bill_id',$bill_id)->sum('quantity');
        return compact('bill','metal','paper','plastic');
    }




}
