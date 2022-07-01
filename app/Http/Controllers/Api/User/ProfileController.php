<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Role;
use App\Models\Supplies;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Validator;


class ProfileController extends Controller
{
    use GeneralTrait;
    public function index()
    {
        # code...
        $profile = Profile::all();
        return $this->sendResponse($profile->toArray(), 'profile  succesfully');
    }

    public function store(Request $request)
    {
        # code...
        $file_name = $this->saveImage($request->photo, 'images');
        // $input = $request->all();

        $input = Profile::create([
            'photo' => $file_name,
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);
        $validator =    Validator::make($input, [
            'name'=> 'required',
            'email'=>'required',
            'password'=> 'required',
            'photo'=> 'required'
        ] );

        if ($validator->fails()) {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }


    }

    public function show(  $id)
    {
        $profile = Profile::find($id);
        if (   is_null($profile)   ) {
            # code...
            return $this->sendError(  '$profile not found ! ');
        }
        return $this->sendResponse($profile->toArray(), 'profile succesfully');

    }



// update
    public function update(Request $request , Profile $profile)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name'=> 'required',
            'email'=> 'required',
            'password'=> 'required',
            'photo'=> 'required'

        ] );

        if ($validator -> fails()) {
            # code...
            return $this->sendError('error validation', $validator->errors());
        }
        $profile->name =  $input['name'];
        $profile->email =  $input['email'];
        $profile->password =  $input['password'];
        $profile->photo =  $input['photo'];
        $profile->save();
        return $this->sendResponse($profile->toArray(), 'profile  updated succesfully');
    }


    public function destroy(Profile $profile)
    {

        $profile->delete();

        return $this->sendResponse($profile->toArray(), 'profile  deleted succesfully');

    }



    public function getPhoto($ssn)
    {
        $photo=User::where('ssn',$ssn)->get('photo');

        return $this->sendResponse($photo, 'get photo succesfully');
    }

    public function points($ssn)
    {
        $metal=0;
        $plastic=0;
        $paper=0;
        $points=0;
        // $category=Supplies::get('category');
        $metal=Supplies::where('category','metal')->where('ssn',$ssn)->sum('quantity');
        $paper=Supplies::where('category','pepar')->where('ssn',$ssn)->sum('quantity');
        $plastic=Supplies::where('category','plastic')->where('ssn',$ssn)->sum('quantity');
        // $quentity= Supplies::where('ssn',$ssn)->sum('quantity');
        return $points =  ($metal*5) + ($paper*2) + ($plastic*3);
        //return $total=(($metal*5)* $Supp) + (($paper*2)* $Supp ) + (($plastic*3)* $Supp);
    }


    public function getKillos($ssn)
    {
        $killos=Supplies::where('ssn',$ssn)->sum('quantity');

        return $this->sendResponse($killos, 'get sum of killos succesfully');

    }

    public function getTotal($ssn)
    {
        $total=0;
        $metal=Supplies::where('category','metal')->where('ssn',$ssn)->sum('quantity');
        $paper=Supplies::where('category','pepar')->where('ssn',$ssn)->sum('quantity');
        $plastic=Supplies::where('category','plastic')->where('ssn',$ssn)->sum('quantity');
        $points =  ($metal*5) + ($paper*2) + ($plastic*3);
        $killos=Supplies::where('ssn',$ssn)->sum('quantity');
        $total=$points/$killos;
        return $this->sendResponse($total, 'get total succesfully');

    }



    public function getLastMonthRecords($ssn){

        $last_Day= Supplies::where('created_at','>=',\Carbon\Carbon::now()->subdays(1))->where('ssn',$ssn)->get();
        $last_month= Supplies:: whereMonth('created_at', '=', \Carbon\Carbon::now()->subMonth()->month)->get();
        // $last_month= Supplies::whereMonth('created_at', '=', \Carbon\Carbon::now()->subMonth()->month)->get();
    //   return $this->sendResponse($last_month->toArray(), 'get data for last month succesfully');
    return $last_Day;
    }

    public function quentitiy_metal($ssn){
    $metal=Supplies::where('category','metal')->where('ssn',$ssn)->sum('quantity');
    return $this->sendResponse($metal, 'get total succesfully');

    }


    public function get_quentitiy($ssn){
        $paper=Supplies::where('category','pepar')->where('ssn',$ssn)->sum('quantity');
        $plastic=Supplies::where('category','plastic')->where('ssn',$ssn)->sum('quantity');
        $pepar=Supplies::where('category','pepar')->where('ssn',$ssn)->sum('quantity');
        return $this->sendResponse(compact('metal','plastic','pepar'), 'get paper succesfully');

        }

        public function quentitiy_plastic($ssn){

            $plastic=Supplies::where('category','plastic')->where('ssn',$ssn)->sum('quantity');
            return $this->sendResponse($plastic, 'get paper succesfully');

            }

}


