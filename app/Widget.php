<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
    public function graphic()
    {
        return $this->belongsTo('App\Graphic', 'df_graphic_id');  // ogni widget ha solo una tipologia graphic . Definita chiave esterna perchè NoN default
    }


}
