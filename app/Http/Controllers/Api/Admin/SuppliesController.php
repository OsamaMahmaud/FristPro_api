<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplies;
use App\Models\User;
use App\Models\Category;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;

class SuppliesController extends Controller
{

        //All category
         use GeneralTrait;
         public function index()
         {
             # code...
             $supplies = Supplies::all();
             return $this->sendResponse($supplies->toArray(), 'All supplies');
         }

         //post category
         public function store(Request $request)
         {
             # code...
             $input = $request->all();
             $validator = Validator::make($input, [
                 'ssn'=> 'required',
                 'category'=> 'required',
                 'quantity'=> 'required',
                 'unit'=> 'required',

             ] );

             if ($validator->fails()) {
                 $code = $this->returnCodeAccordingToInput($validator);
                 return $this->returnValidationError($code, $validator);
             }

             $supplies = Supplies::create($input);
             return $this->sendResponse($supplies->toArray(), 'Supplies  created succesfully');

         }

         //show category
         public function show( $id)
         {
             $supplies = Supplies::find($id);
             if (   is_null($supplies)   ) {
                 # code...
                 return $this->sendError(  'supplies not found ! ');
             }
             return $this->sendResponse($supplies->toArray(), 'show supplies succesfully');

         }



     // update category
         public function update(Request $request , Supplies $supplies)
         {
             $input = $request->all();
             $validator = Validator::make($input, [
                'ssn'=> 'required',
                'category'=> 'required',
                'quantity'=> 'required',
                'unit'=> 'required',
             ] );

             if ($validator -> fails()) {
                 # code...
                 return $this->sendError('error validation', $validator->errors());
             }
             $supplies->ssn =  $input['ssn'];
             $supplies->category =  $input['category'];
             $supplies->quantity =  $input['quantity'];
             $supplies->unit =  $input['unit'];
             $supplies->save();
             return $this->sendResponse($supplies->toArray(), 'supplies  updated succesfully');

         }

     // delete category
         public function destroy(Supplies $supplies)
         {
             $supplies->delete();
             return $this->sendResponse($supplies->toArray(), 'supplies  deleted succesfully');

         }
     ///////////get all ssn
         public function getuser(){
             $user=User::get('ssn');
             return $this->sendResponse($user->toArray(), '  get all ssn succesfully');

         }

         ///////////get all category
         public function getcategory(){
            $categ=Category::get('name');
            return $this->sendResponse($categ->toArray(), '  get all category succesfully');

        }

        public function getquantity(){
            $ssn=Supplies::get('ssn');
            $Supp= Supplies::where('ssn',$ssn)->sum('quantity');
            // $Supp=Supplies::get('quantity');
            return $this->sendResponse($Supp->toArray(), '  get all quantity succesfully');
        }




        ///sum quantity





     }
