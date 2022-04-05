<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Department extends Authenticatable  implements JWTSubject
{

    protected $table = 'department';

    protected $fillable = [
        'name'
    ];

    protected $hidden=['pivot'];


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

    public function employees(){
        return $this -> belongsToMany('App\Models\AddEmployee','emp_dept','emp_id','dept_id','id','id');
    }


    public function employee(){
        return $this -> hasMany('App\Models\AddEmployee','dept_id','id');
    }

}
