<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StType extends Model
{
    
    //
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'df_stTypes';


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
    public function nodes()
    {
        return $this->hasMany('App\Node', 'df_stType_id'); 
    }





}
