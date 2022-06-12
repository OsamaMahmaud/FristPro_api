<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class AddEmployee extends Authenticatable  implements JWTSubject
{

    protected $table = 'employee';

    protected $fillable = [
        'name', 'address','email','password','dept_id','role_id'
    ];

    // protected $fillable = [
    //     'name', 'address','email','password','admin_id','dept_id','car_id','role_id'
    // ];


    // protected $hidden = [
    //     'admin_id'
    // ];
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
