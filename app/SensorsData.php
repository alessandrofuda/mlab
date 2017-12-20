<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Sensor;



class SensorsData extends Model
{
    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vl_sensorsData';


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
    public function sensors()
    {
        return $this->belongsTo('App\Sensor', 'el_sensor_id'); 
    }



}
