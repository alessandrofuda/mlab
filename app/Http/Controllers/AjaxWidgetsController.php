<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



class AjaxWidgetsController extends Controller
{


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    { 
        // $this->middleware('ajax');  ////////////////////////////////// !!! DE-COMMENTARE DOPO TEST ...
    }


    public function getDataWidgetOne() {

    	//
    	$data1 = '{
		  "cols": [
		        {"id":"","label":"Dates","pattern":"","type":"string"},
		        {"id":"","label":"Hourly Energy","pattern":"","type":"number"}
		      ],
		  "rows": [
		        {"c":[{"v":"data1","f":null},{"v":9,"f":null}]},
		        {"c":[{"v":"data2","f":null},{"v":8,"f":null}]},
		        {"c":[{"v":"data3","f":null},{"v":6,"f":null}]},
		        {"c":[{"v":"data4","f":null},{"v":9,"f":null}]},
		        {"c":[{"v":"data5","f":null},{"v":10,"f":null}]},
		      ]
		}';

		return $data1;
    	// return response()->json($queryResults); // !!  also can use the facade
    }


}
