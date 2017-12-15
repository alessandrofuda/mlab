<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\UserDashboardWidget;


class AjaxDashboardController extends Controller
{   

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth'); 


        // dashboard dalla quale proviene la chiamata !!  sistemare!!!
        // $this->current_dashboard = 1; //$current_dashboard; // per ora; HARD CODED !!!!!!!!!!!!!

    }




    public function repositioning(Request $request){

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
	        $dashboard_id = $request->widgets[0]['dashboard_id']; 
	        
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

	        return 'Ok: Ajax. Updated widgets in db.'; 

        /* } */  

    }


    public function deactivate_widget(Request $request) {
    	
    	// validation
    	$rules = array(
    		'id' => 'integer|required',
    		);
    	$validator = Validator::make($request->all(), $rules);

    	if ($validator->fails()) {
            return 'Ajax validation error';
        } else { 

	    	$user_id = Auth::user()->id;  // per utente autenticato !! Per modificare le dashboard di altri user (da Admin) modificare questa variabile.
		    $dashboard_id = 1; // per ora; HARD CODED !!!!!!!!!!!!! 

		    $widget_deactivate = UserDashboardWidget::where('user_id', $user_id)
		    										->where('dashboard_id', $dashboard_id)
		    										->where('widget_id', $request->id)
		    										->first();
	    	
	    	$widget_deactivate->active = 0;
	    	$widget_deactivate->save();

    	}

    	return 'Ok widget '.$request->id.' deactivated in Db';

    }





    //public function activate_widget(Request $request) {
    	//	
    //}



}
