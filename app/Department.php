<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'el_departments';


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
        return $this->hasMany('App\Subscription', 'department_id'); 
    }

}
