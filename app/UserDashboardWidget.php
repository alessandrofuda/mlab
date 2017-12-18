<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Widget;


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
    protected $fillable = ['user_id', 'dashboard_id', 'widget_id', 'x', 'y', 'width', 'height', 'active'];  



    // IMPORTANT! 

    /**
    * Relationships
    *
    *
    */
    public function users()
    {
        return $this->belongsTo('App\User', 'user_id'); 
    }


    /**
    * Relationships
    *
    *
    */
    public function dashboard()
    {
        return $this->belongsTo('App\Dashboard', 'dashboard_id'); 
    }


    /**
    * Relationships
    *
    *
    */
    public function widgets()
    {
        return $this->belongsTo('App\Widget', 'widget_id');  

    }



}
