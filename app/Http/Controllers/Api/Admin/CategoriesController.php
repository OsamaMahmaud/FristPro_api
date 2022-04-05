<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Factory;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;



class CategoriesController extends Controller
{
   //All category
    use GeneralTrait;
    public function index()
    {
        # code...
        $profile = Category::all();
        return $this->sendResponse($profile->toArray(), 'All Categorys');

    }

    //post category
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

        $profile = Category::create($input);
        return $this->sendResponse($profile->toArray(), 'Category  created succesfully');

    }

    //show category
    public function show(  $id)
    {
        $profile = Category::find($id);
        if (   is_null($profile)   ) {
            # code...
            return $this->sendError(  '$Category not found ! ');
        }
        return $this->sendResponse($profile->toArray(), 'show category succesfully');

    }



// update category
    public function update(Request $request , Category $profile)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name'=> 'required',
        ] );

        if ($validator -> fails()) {
            # code...
            return $this->sendError('error validation', $validator->errors());
        }
        $profile->name =  $input['name'];
        $profile->save();
        return $this->sendResponse($profile->toArray(), 'Category  updated succesfully');

    }

// delete category
    public function destroy(Category $profile)
    {
        $profile->delete();
        return $this->sendResponse($profile->toArray(), 'Category  deleted succesfully');

    }

}
