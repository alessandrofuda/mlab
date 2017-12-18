<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\UserDashboardWidget;
use App\Dashboard;
use App\User;
use \DB;


class AjaxDashboardController extends Controller
{   

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    { 
        $this->middleware('ajax');
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
		    $dashboard_id = $request->dashboard_id; 

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



    /**
    *   Admin side: Dashboard customization page --> select user/dashboard to modify
    *
    */
    public function admin_select_user($user_id) {

        $dashboards = UserDashboardWidget::with('dashboard:id,name')
                                        ->where('user_id', $user_id)
                                        ->orderBy('dashboard_id')
                                        ->groupBy('dashboard_id')
                                        ->get();
        // groupBy --> per fuzionare con eloquent disabilitare strict mode in config/database.php (con larav 5.5 di default è true)

        /*$dashboards = DB::table('lr_user_dashboard_widget')
                        ->select('dashboard_id') //, \DB::raw('count(*) as total'))
                        ->groupBy('dashboard_id')
                        ->get();*/

        return json_encode($dashboards);

    }




    /**
    *   Admin side: Dashboard customization & redesign
    *
    */
    public function redesign_user_dashboard($user_id, $dashboard_id) {

        $user_name = User::find($user_id)->first()->name;
        $dashboard_name = Dashboard::find($dashboard_id)->first()->name;
        $title = '<p>User Dashboard: '. $user_name . '</p><p>Title Dashboard: '. $dashboard_name .'</p>';
        // return json_encode($title);

        $widgets = UserDashboardWidget::where('user_id', $user_id )
                                        ->where('dashboard_id', $dashboard_id)
                                        // ->with('widgets', 'users')
                                        ->get();



        return json_encode($widgets);

        // deve ritornare la stessa pagina con tutti i widget querizzati       

        // return view('admin.home', compact('title', 'current_dashboard', 'widgets')); 

    }



}
