<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Addarea extends Model
{
    protected $table = 'addarea';

    // protected $fillable = [
    //     'name_ar', 'name_en','active','created_at', 'updated_at'
    // ];


    protected $fillable = [
        'name'
    ];

    //protected $hidden =['created_at','updated_at','pivot'];

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




