<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class AddEmployee extends Authenticatable  implements JWTSubject
{

    protected $table = 'employee';

    protected $fillable = [
        'name', 'address','email','password','admin_id','car_id','dept_id'
    ];

    protected $hidden = [
        'admin_id'
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

    public function admin(){
        return $this -> belongsTo('App\Models\Admin','admin_id','id');
    }



    public function Car(){
        return $this -> belongsTo('App\Models\Car','car_id','id');
    }


    // public function department(){
    //     return $this -> belongsToMany('App\Models\Department','emp_dept','emp_id','dept_id','id','id');
    // }



    public function department(){
        return $this -> belongsTo('App\Models\Department','dept_id','id');
    }


}
