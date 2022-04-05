<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fact_Category extends Model
{
    protected $table = 'emp_dept';

    // protected $fillable = [
    //     'name_ar', 'name_en','active','created_at', 'updated_at'
    // ];


    protected $fillable = [
       'emp_id','dept_id'
    ];

    // protected $hidden=['id'];
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




}




