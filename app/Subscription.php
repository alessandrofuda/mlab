<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lr_subscriptions';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [...];
    protected $guarded = [];


    /**
    * Relationships
    *
    *
    */
    public function users()
    {
        return $this->belongsTo('App\User', 'user_id'); 
    }


    public function customers()
    {
        return $this->belongsTo('App\Customer', 'customer_id'); 
    }


    public function plants()
    {
        return $this->belongsTo('App\Plant', 'plant_id'); 
    }


    public function departments()
    {
        return $this->belongsTo('App\Department', 'department_id'); 
    }


    public function sensors()
    {
        return $this->belongsTo('App\Sensor', 'sensor_id'); 
    }



    public function actuators()
    {
        return $this->belongsTo('App\Actuator', 'actuator_id'); 
    }



}
