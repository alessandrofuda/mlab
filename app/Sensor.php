<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
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
        return $this->hasMany('SensorsData', 'el_sensor_id'); 
    }



}
