<?php


namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplies;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;

class GetquantityController extends Controller
{
    use GeneralTrait;


    public function get_quentitiy($ssn){
        $pepar=Supplies::where('category','pepar')->where('ssn',$ssn)->sum('quantity');
        $plastic=Supplies::where('category','plastic')->where('ssn',$ssn)->sum('quantity');
        $metal=Supplies::where('category','metal')->where('ssn',$ssn)->sum('quantity');
        // return $pepar;
        return $this->sendResponse(compact('metal','plastic','pepar'), 'get paper succesfully');
        }
}

