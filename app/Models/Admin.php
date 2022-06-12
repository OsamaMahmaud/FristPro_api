<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Admin extends Authenticatable  implements JWTSubject
{

    protected $table = 'admins';

    protected $fillable = [
        'name', 'email','password','passwordconfirmation','address','role_id','dept_id'
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


    public function Car(){
        return $this -> belongsTo('App\Models\Car','car_id','id');
    }

    // public function department(){
    //     return $this -> belongsToMany('App\Models\Department','emp_dept','emp_id','dept_id','id','id');
    // }


    public function department(){
        return $this -> belongsTo('App\Models\Department','dept_id','id');
    }





    public function employee(){
        return $this -> hasMany('App\Models\AddEmployee','admin_id');
    }


    public function role()
    {
        return $this->belongsTo('App\Models\Role','role_id');
    }

    public function hasAbility($permissions)    //products  //mahoud -> admin can't see brands
    {
        $role = $this->role;

        if (!$role) {
            return false;
        }

        foreach ($role->permissions as $permission) {
            if (is_array($permissions) && in_array($permission, $permissions)) {
                return true;
            } else if (is_string($permissions) && strcmp($permissions, $permission) == 0) {
                return true;
            }
        }
        return false;
    }


}


