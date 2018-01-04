<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Sensor;


class SensorsDescriptor extends Model
{
    //
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'el_sensorsDescriptors';


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
        return $this->hasMany('App\Sensor', 'el_sensorsDescriptor_id'); 
    }




}
