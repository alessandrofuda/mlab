<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UserDashboardWidget;

class Widget extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lr_widgets';


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
    public function graphics()
    {
        return $this->belongsTo('App\Graphic', 'df_graphic_id');  // ogni widget ha solo una tipologia graphic . Definita chiave esterna perchè NoN default
    }


    /**
    * Relationships
    *
    *
    */
    public function userDashboardWidget()
    {
        return $this->hasMany('App\UserDashboardWidget', 'widget_id');  
    }



    /**
    * Relationships
    *
    *
    */
    //public function users()
    //{
    //    return $this->belongsToMany('App\User', 'lr_user_dashboard_widget', 'widget_id', 'user_id');  //, 'widget_id', 'user_id'); 
        // return $this->belongsToMany('App\Widget');

    //}



}
