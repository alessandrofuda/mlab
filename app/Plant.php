<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'el_plants';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [];



    /**
    * Relationships
    *
    *
    */
    public function subscriptions()
    {
        return $this->hasMany('App\Subscription', 'plant_id'); 
    }

}
