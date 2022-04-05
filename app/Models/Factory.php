<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factory extends Model
{
    protected $table = 'factory';



    protected $fillable = [
        'factory_name','contact_num','factory_location','category_id'
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



    // public function categories(){
    //     return $this -> belongsToMany('App\Models\Category','fact_category','factory_id','category_id','id','id');
    // }

    public function  Category(){
        return $this ->  belongsTo('App\Category','category_id');
    }

}




