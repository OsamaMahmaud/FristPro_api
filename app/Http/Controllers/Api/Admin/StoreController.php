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



class StoreController extends Controller
{

    use GeneralTrait;
    public function getallquantity()
    {
        $metal=Supplies::where('category','metal')->sum('quantity');
        // return $metal;
        $plastic=Supplies::where('category','plastic')->sum('quantity');
        $pepar=Supplies::where('category','pepar')->sum('quantity');
        return compact('metal','plastic','pepar');
    }

}



