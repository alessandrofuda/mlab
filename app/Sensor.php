<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\SensorsDescriptor;
use App\SensorsData;



class Sensor extends Model
{
    //


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'el_sensors';


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
    public function sensorsData()
    {
        return $this->hasMany('App\SensorsData', 'el_sensor_id'); 
    }


    /**
    * Relationships
    *
    *
    */
    public function sensorsDescriptor()
    {
        return $this->belongsTo('App\SensorsDescriptor', 'el_sensorsDescriptor_id'); 
    }



}
