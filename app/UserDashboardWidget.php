<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDashboardWidget extends Model
{
    
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lr_user_dashboard_widget';


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
    public function user()
    {
        return $this->belongsToMany('App\User', 'user_id'); 
    }


    /**
    * Relationships
    *
    *
    */
    public function dashboard()
    {
        return $this->belongsToMany('App\Dashboard', 'dashboard_id'); 
    }


    /**
    * Relationships
    *
    *
    */
    public function widget()
    {
        return $this->belongsToMany('App\User', 'widget_id'); 
    }



}
