<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Sensor;



class SensorsCode extends Model
{
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'df_sensorsCodes';


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
        return $this->hasMany('App\Sensor', 'df_sensorsCode_id'); 
    }




}
