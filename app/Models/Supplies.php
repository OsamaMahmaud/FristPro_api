<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplies extends Model
{
    protected $table = 'supplies';

    protected $fillable = [
        'ssn', 'category','quantity','unit'
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




