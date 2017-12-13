<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lr_dashboards';



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [''];


    /**
    * Relationships
    *
    *
    */
    public function userDashboardWidget()
    {
        return $this->hasMany('App\userDashboardWidget');  
    }
    

}
