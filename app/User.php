<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    // use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lr_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'node_id', 'logo', 'password', 'is_admin', 'is_actuator'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    //protected $dates = ['deleted_at'];


    /**
    * Relationships
    *
    *
    */
    public function dashboard()
    {
        return $this->hasMany('App\Dashboard'); 
    }


    /**
    * Relationships
    *
    *
    */
    public function widget()
    {
        return $this->hasMany('App\Widget');  
    }


    /**
    * Relationships
    *
    *
    */
    public function userDashboardWidget()
    {
        return $this->hasMany('App\UserDashboardWidget', 'user_id');  
    }


    /**
    * Relationships
    *
    *
    */
    public function subscriptions()
    {
        return $this->hasMany('App\Subscription', 'user_id'); 
    }


    /**
    * Relationships
    *
    *
    */
    public function nodes()
    {
        return $this->belongsTo('App\Node', 'node_id'); 
    }



}
