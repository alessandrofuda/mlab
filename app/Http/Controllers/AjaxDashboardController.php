<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\UserDashboardWidget;
use Validator;


class AjaxDashboardController extends Controller
{
    public function repositioning(Request $request){

    	//$test = $request->widgets[0]['id'];
    	//return $test;   

    	// validation form
        /* $rules = array(
            'id' => 'integer|required',
            'x' => 'integer|required',
            'y' => 'integer|required',
            'width' => 'integer|required',
            'height'=> 'integer|required',
            'active' => 'boolean|required',
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return 'Ajax validation error';

        } else { */

            // update in db

            $user_id = Auth::user()->id;  // per utente autenticato !! Per modificare le dashboard di altri user (da Admin) modificare questa variabile.
	        $dashboard_id = 1; // per ora: Hard Coded !!
	        
	        foreach ($request->widgets as $widget) {
	            $widget_remap = UserDashboardWidget::where('user_id', $user_id)
	            									->where('dashboard_id', $dashboard_id)
	            									->where('widget_id', $widget['id'])
	            									->first();

	            $widget_remap->x = $widget['x'];
	            $widget_remap->y = $widget['y'];
	            $widget_remap->width = $widget['width'];
	            $widget_remap->height = $widget['height'];
	            $widget_remap->active = $widget['active'];
	            
	            $widget_remap->save();

	        }

	        return 'Ok: Ajax. Updated widgets in db.';    // .$widget['id'].' updated in db (x:'.$widget_remap->x.', y:'.$widget_remap->y.', width:'.$widget_remap->width.', height:'.$widget_remap->height.', active:'.$widget_remap->active.')';

        /*}  */  

    }


}
