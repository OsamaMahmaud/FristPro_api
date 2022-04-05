<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Factory;
use App\Models\Fact_Category;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;



class FactCategoryController extends Controller
{
   //All category
    use GeneralTrait;

















    public function index()
    {
        # code...
        $fact_categ = Fact_Category::select('*')->get();
        $categores=Category::select('name')->get();
        $factory=Factory::select('factory_name')->get();
        // $fact_id= $fact_categ->factory_id;

        return $this->sendResponse($fact_categ->toArray(), 'All fact_category');

    }

    //post category
    public function store(Request $request)
    {
        # code...
        $input = $request->Category::select('name')->get();
        $input  = $request->Factory::select('factory_name')->get();;



        return $this->sendResponse($input->toArray(), 'All fact_category');


        // $validator = Validator::make($input, [
        //     'factory_id'=> 'required',
        //     'category_id'=> 'required',

        // ] );

        // if ($validator->fails()) {
        //     $code = $this->returnCodeAccordingToInput($validator);
        //     return $this->returnValidationError($code, $validator);
        // }



        // return $this->sendResponse($profile->toArray(), 'Category  created succesfully');

    }

    //show category
    public function show(  $id)
    {
        $profile = Fact_Category::find($id);
        if (   is_null($profile)   ) {
            # code...
            return $this->sendError(  'Fact_Category not found ! ');
        }
        return $this->sendResponse($profile->toArray(), 'show Fact_Category succesfully');

    }



// update category
    public function update(Request $request , Fact_Category $profile)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'factory_id'=> 'required',
            'category_id'=> 'required',
        ] );

        if ($validator -> fails()) {
            # code...
            return $this->sendError('error validation', $validator->errors());
        }
        $profile->factory_id =  $input['factory_id'];
        $profile->category_id =  $input['category_id'];
        $profile->save();
        return $this->sendResponse($profile->toArray(), 'Fact_Category  updated succesfully');

    }

// delete category
    public function destroy(Fact_Category $profile)
    {
        $profile->delete();
        return $this->sendResponse($profile->toArray(), 'Fact_Category  deleted succesfully');

    }

}
