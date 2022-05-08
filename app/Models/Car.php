<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $table = 'car';

    protected $fillable = [
         'drivers_name'
    ];

    public $timestamps = false;

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function employee(){
        return $this -> hasMany('App\Models\AddEmployee','car_id');
    }

    //    //has one through
    //    public function department(){
    //     return $this -> hasOneThrough('App\Models\AddEmployee','App\Models\Department','car_id','emp_id','id','id');
    // }



}




