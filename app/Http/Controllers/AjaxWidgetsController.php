<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SensorsData;
use Carbon\Carbon; 
use App\Sensor;
use Auth;
use DB;



class AjaxWidgetsController extends Controller
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



    /**
     *	Get sensors's Array of current user
     *
     *	@return array of sensors of Auth user
     */
    public function getSensorsArray() {

		// if Admin --> fetch all sensors
    	if (Auth::user()->is_admin == 1) {

    		$node_id = null;
    		$all_sensors = Sensor::get(['id']);
    		$sensors_arr = [];
    		foreach ($all_sensors as $all_sensor) {
    			$sensors_arr[] = $all_sensor->id;
    		}

    	} else {  // fetch only subTree nodes

    		if(!isset(Auth::user()->node_id)){
    			return 'error: node_id not set for this user.';
    		}

    		$node_id = Auth::user()->node_id;
    		$subtree = DB::select('call subTree('.$node_id.')');
	    	$sensors_arr = [];
	    	$sensorType = 6;  // IMP. 6 identifica solo il sensore! (esclude actuator)
	    	foreach ($subtree as $subNode) {
	    		if($subNode->df_stType_id == $sensorType) {
	    			$sensors_arr[] = $subNode->id;
	    		}
	    	}
    	}

    	return $sensors_arr;
    }

    


    public function getActuatorsArray() {
    	//
    }



    public function createJsonData() {
    	//
    }




    public function getDataWidgetOne() {
 
    	$sensors_arr = $this->getSensorsArray();  // IMPORTANTE: filtrare l'array con i soli sensori NON HIDDEN !!!!
    	// return $sensors_arr;
    	// hourly/daily/monthly/yearly
    	//$aggregationLevel = 'Hour(createdOn)';  // hourly
    	// $aggregationLevel = 'Date(createdOn)';  // daily
    	//$aggregationLevel = 'Month(createdOn)'; //monthly
    	//$aggregationLevel = 'Year(createdOn)';  // yearly
		$startDate = '';
		$endDate = '';



		



    	/* ----------- BLOCCO COLS ---------------------- */
    	$queryCols = SensorsData::with('sensors.sensorsDescriptor')->whereIn('el_sensor_id', $sensors_arr)
    															   ->groupBy('el_sensor_id')
    															   ->get(['el_sensor_id','sensorData']);
    	//return $queryCols;
    	$cols_arr = '';
		$cols_arr .= '{"id":"time","label":"time","pattern":"","type":"date"},';

		foreach ($queryCols as $queryCol) {
			$cols_arr .= '{"id":"sensor-'.$queryCol->el_sensor_id.'","label":"'.$queryCol->sensors->sensorsDescriptor->shortDescr.'","pattern":"","type":"number"},';
		}  
		$cols_arr = rtrim($cols_arr, ',');

//return $cols_arr;
		/* ------------- FINE BLOCCO COLS ------------------ */


    	/*--------------- BLOCCO ROWS ------------------- */
		$rows_arr = '';

		// ---> array DATES/TIMES
		$dates_obj = SensorsData::whereIn('el_sensor_id', $sensors_arr)
								//->whereDate('createdOn', '>=', '%'.$startDate.'%')
								//->whereDate('createdOn', '<=', '%'.$endDate.'%')
								//->groupBy(DB::raw( $aggregationLevel ))   // Date(createdOn)
								//->get([DB::raw($aggregationLevel.' as datetime')]);   
								->get(['createdOn as datetime']);
								//return $dates_obj;
		$dates = [];
		foreach ($dates_obj as $date_item) {
			/* $datetime_expl = explode(' ', $date_item->datetime);
			$date = $datetime_expl[0];
			$time = $datetime_expl[1];
			$date_expl = explode('-', $date);
			 
			if ( $aggregationLevel == 'Hour(createdOn)' ) {   // hourly
				$dates[] = $time;
			} elseif ($aggregationLevel == 'Date(createdOn)') {  // daily
				$dates[] = $date;
			} elseif ($aggregationLevel == 'Month(createdOn)') {  // monthly
				$month = $date_expl[1];
				$dates[] = '-'.$month.'-';
			} elseif ($aggregationLevel == 'Year(createdOn)') {   // yearly
				$year = $date_expl[0];
				$dates[] = $year.'-';
			} else {
				$dates[] = $date;
			}*/
			$dates[] = $date_item->datetime;
			
		}




// return $dates;






		// ---> array SENSORS (realmente presenti in DB!->important!)
		$sensors_obj = SensorsData::whereIn('el_sensor_id', $sensors_arr)
								  ->groupBy('el_sensor_id')
								  ->get(['el_sensor_id']);
		$sensors = [];
		foreach ($sensors_obj as $sensor_item) {
			$sensors[] = $sensor_item->el_sensor_id;
		}

		
		// ---> MAIN QUERY
		foreach ($dates as $date) { // [0,1,2,3,4,5,6,7,8,9,....23] hourly
			$sensors_values = '';
			//$sensors = [5,6];  // TEST 5 -> quartoraria   6->oraria
			foreach ($sensors as $sensor) {
				
				$value = SensorsData::where('createdOn', $date)
									//->groupBy(DB::raw('Date(createdOn)'), 'el_sensor_id')  //   // pulisce in caso di doppioni
									->where('el_sensor_id', $sensor)
												//->select('createdOn', 'el_sensor_id', DB::raw('SUM(sensorData) as sum'))
									//->select(DB::raw('SUM(sensorData) as sum'))
									->first();  // ->sum only if exist
									
				$value = $value === null ? '0' : $value->sensorData; // !! IMPORT.cambiare quando ci sarà la tab. con consumi energia (anzichè con le letture)!!
//return $value;

				$sensors_values .= '{"v": '.$value.', "f":null},'; // qui impostare query .. $sensor->value
				// return $sensors_values;
			}
			$sensors_values = rtrim($sensors_values, ',');
			

			// return $date;

			
			/* if ( $aggregationLevel == 'Hour(createdOn)' ) {
				$time = explode(':', $date);
				$hh = $time[0];
				$ii = $time[1];
				$ss = $time[2];
				$time_values = '['.$hh.' , '.$ii.', '.$ss.']';

			} elseif ( $aggregationLevel == 'Date(createdOn)' ) {
				///////////////////////////////////////////////

				$time_values = 'Date('.$yyyy.', '.$mm.', '.$dd.', '.$hh.', '.$ii.', '.$ss.')';

			} elseif ( $aggregationLevel == 'Month(createdOn)' ) {
				$time_values = 'Date('.$yyyy.', '.$mm.')';

			} elseif ( $aggregationLevel == 'Year(createdOn)' ) {
				$time_values = 'Date('.$yyyy.')';
			} else {
				$time_values = '';
			} */
			 
			//$rows_arr .= '{"c":[{"v":"Date('.$yyyy.', '.$mm.', '.$dd.', '.$hh.', '.$ii.', '.$ss.')","f":null}, '.$sensors_values. ']}, ';
			$date_arr = explode(' ', $date);
			$date1 = $date_arr[0];
			$date1 = explode('-', $date1);
			$time = $date_arr[1];
			$time = explode(':', $time);
			$yyyy = $date1[0];
			$mm = $date1[1]-1;  // js months format from 0 to 11
			$dd = $date1[2];
			$hh = $time[0];
			$ii = $time[1];
			$ss = $time[2];

			$rows_arr .= '{"c":[{"v":"Date('.$yyyy.', '.$mm.', '.$dd.', '.$hh.', '.$ii.', '.$ss.')","f":null}, '.$sensors_values. ']},';
			
		}
		//return $rows_arr;
		$rows_arr = rtrim($rows_arr, ',');
		//return $rows_arr;






// return $rows_arr;
		/* ---------------- FINE BLOCCO ROWS ------------------ */

    	
    	// ---> CREATE JSON DATA
    	$cols = '"cols": [' . $cols_arr . '],';
    	$rows = '"rows": [' . $rows_arr . ']';
    	$data = '{'. $cols . $rows . '}'; 


    	
    	// come settare timeofday nel json ??? : https://developers.google.com/chart/interactive/docs/datesandtimes  search time of day
    	// 													"type":"date"
    	// https://developers.google.com/chart/interactive/docs/reference#dateformatter
    	// timeofday: v: senza virgolette !!!!!!!


    	 /*$data = '{
				"cols": [
			        {"id":"month","label":"Months","pattern":"","type":"date"},  
			        {"id":"sensor-5","label":"Sensor-5","pattern":"","type":"number"}, 
			        {"id":"sensor-6","label":"Sensor-6","pattern":"","type":"number"}

			    ],			    
			  	"rows": [										
			        {"c":[{"v":"Date(2018, 01)","f":null},{"v": 88, "f":null},{"v": 99,"f":null},{"v": 85,"f":null}]}, 
			        {"c":[{"v":"Date(2018, 02)","f":null},{"v": 90, "f":null},{"v": 95,"f":null},{"v": 75,"f":null}]},
			        {"c":[{"v":"Date(2018, 03)","f":null},{"v": 90, "f":null},{"v": 95,"f":null},{"v": 75,"f":null}]}
			    ],
			    "p": []
		}'; */
		/*{"id":"sensor-7","label":"Sensor-7","pattern":"","type":"number"},*/

/* {"c":[{"v":"Date(14, 00, 00)","f":null},{"v": 95, "f":null},{"v": 84,"f":null},{"v": 96,"f":null}]},
			        {"c":[{"v":"Date(15, 00, 00)","f":null},{"v": 80, "f":null},{"v": 49,"f":null},{"v": 88,"f":null}]},
			        {"c":[{"v":"Date(16, 00, 00)","f":null},{"v": 70, "f":null},{"v": 70,"f":null},{"v": 99,"f":null}]},
			        {"c":[{"v":"Date(17, 00, 00)","f":null},{"v": 78, "f":null},{"v": 60,"f":null},{"v": 80,"f":null}]},
			        {"c":[{"v":"Date(18, 00, 00)","f":null},{"v": 78, "f":null},{"v": 60,"f":null},{"v": 70,"f":null}]},
			        {"c":[{"v":"Date(19, 00, 00)","f":null},{"v": 58, "f":null},{"v": 40,"f":null},{"v": 60,"f":null}]},
			        {"c":[{"v":"Date(20, 00, 00)","f":null},{"v": 72, "f":null},{"v": 60,"f":null},{"v": 79,"f":null}]},
			        {"c":[{"v":"Date(21, 00, 00)","f":null},{"v": 68, "f":null},{"v": 70,"f":null},{"v": 89,"f":null}]},
			        {"c":[{"v":"Date(22, 00, 00)","f":null},{"v": 78, "f":null},{"v": 55,"f":null},{"v": 99,"f":null}]},
			        {"c":[{"v":"Date(23, 00, 00)","f":null},{"v": 58, "f":null},{"v": 40,"f":null},{"v": 80,"f":null}]},
*/

    	return $data;

    }



    public function getDataWidgetTwo() {

    	$queryResults = SensorsData::with('sensors')->where('el_sensor_id', 6)->get(['el_sensor_id','readOn','sensorData']);  //->lists()DEPREC. -> pluck()  // ->get(); 
    	// return response()->json($queryResults); // !!  also can use the facade

    	$columnTwoLabel = $queryResults[0]->sensors->shortDescr;
    	// dd($columnTwoLabel);
    	
		//foreach ($queryResults->first()->getAttributes() as $key => $value) {
			$cols_arr =  '{"id":"1","label":"Dates","pattern":"","type":"string"},';  // sostituire string con date (anche sopra)!
			$cols_arr .= '{"id":"2","label":"'. $columnTwoLabel .'","pattern":"","type":"number"},';
		//}
    	
    	//dd($queryResults);
		$rows_arr = '';

		foreach ($queryResults as $queryResult) {
			// dd($queryResult);
			$date = explode(' ', $queryResult->createdOn)[0];  // $date = $date[0];
			$rows_arr .= '{"c":[{"v":"'.$date.'","f":null},{"v":'.$queryResult->sensorData.',"f":null}]},';
		}
    	
    	$cols = '"cols": [' . $cols_arr . '],';
    	$rows = '"rows": [' . $rows_arr . '],';
    	$data = '{'. $cols . $rows . '}'; 

    	return $data;

    }


    public function getDataWidgetThree() {

    	
    	$queryResults = SensorsData::with('sensors')->where('el_sensor_id', 6)->get(['el_sensor_id','readOn','sensorData']); 
		$columnTwoLabel = $queryResults[0]->sensors->shortDescr;
    	

    	
		//foreach ($queryResults->first()->getAttributes() as $key => $value) {
			$cols_arr =  '{"id":"1","label":"Dates","pattern":"","type":"string"},';  // sostituire string con date (anche sopra)!
			$cols_arr .= '{"id":"2","label":"'. $columnTwoLabel .'","pattern":"","type":"number"},';
		//}
    	
		$rows_arr = '';

		foreach ($queryResults as $queryResult) {
			// dd($queryResult);
			$date = explode(' ', $queryResult->readOn)[0];  // $date = $date[0];
			$rows_arr .= '{"c":[{"v":"'.$date.'","f":null},{"v":'.$queryResult->sensorData.',"f":null}]},';
		}
    	
    	$cols = '"cols": [' . $cols_arr . '],';
    	$rows = '"rows": [' . $rows_arr . '],';
    	$data = '{'. $cols . $rows . '}'; 

    	
    	// DUMMY DATA
    	$data = '{   
			  	"cols": [
			        {"id":"A","label":"Departements","pattern":"","type":"string"},  
			        {"id":"B","label":"2017","pattern":"","type":"number"},
			        {"id":"C","label":"2018","pattern":"","type":"number"},
			    ],
			  	"rows": [
			        {"c":[{"v":"Depart. 1","f":null},{"v": 88, "f":null},{"v": 99,"f":null}]}, 
			        {"c":[{"v":"Depart. 2","f":null},{"v": 90, "f":null},{"v": 95,"f":null}]},
			        {"c":[{"v":"Depart. 3","f":null},{"v": 95, "f":null},{"v": 84,"f":null}]},
			        {"c":[{"v":"Depart. 4","f":null},{"v": 80, "f":null},{"v": 49,"f":null}]},
			        {"c":[{"v":"Depart. 5","f":null},{"v": 70, "f":null},{"v": 70,"f":null}]},
			        {"c":[{"v":"Depart. 6","f":null},{"v": 78, "f":null},{"v": 60,"f":null}]},
			    ],
			    "p": {  }
		}';


    	return $data;


    }


    public function getDataWidgetFour() {

    	//
    	$queryResults = SensorsData::with('sensors')->where('el_sensor_id', 6)->get(['el_sensor_id','readOn','sensorData']); 
		$columnTwoLabel = $queryResults[0]->sensors->shortDescr;
    	

    	
		//foreach ($queryResults->first()->getAttributes() as $key => $value) {
			$cols_arr =  '{"id":"1","label":"Dates","pattern":"","type":"string"},';  // sostituire string con date (anche sopra)!
			$cols_arr .= '{"id":"2","label":"'. $columnTwoLabel .'","pattern":"","type":"number"},';
		//}
    	
		$rows_arr = '';

		foreach ($queryResults as $queryResult) {
			// dd($queryResult);
			$date = explode(' ', $queryResult->readOn)[0];  // $date = $date[0];
			$rows_arr .= '{"c":[{"v":"'.$date.'","f":null},{"v":'.$queryResult->sensorData.',"f":null}]},';
		}
    	
    	$cols = '"cols": [' . $cols_arr . '],';
    	$rows = '"rows": [' . $rows_arr . '],';
    	$data = '{'. $cols . $rows . '}'; 

    	
    	// DUMMY DATA
    	$data = '{   
			  	"cols": [
			        {"id":"A","label":"Months","pattern":"","type":"string"},  
			        {"id":"B","label":"Departement-1","pattern":"","type":"number"},
			        {"id":"C","label":"Departement-2","pattern":"","type":"number"},
			        {"id":"D","label":"Departement-3","pattern":"","type":"number"},
			    ],
			  	"rows": [
			        {"c":[{"v":"Gen","f":null},{"v": 88, "f":null},{"v": 99,"f":null},{"v": 85,"f":null}]}, 
			        {"c":[{"v":"Feb","f":null},{"v": 90, "f":null},{"v": 95,"f":null},{"v": 75,"f":null}]},
			        {"c":[{"v":"Mar","f":null},{"v": 95, "f":null},{"v": 84,"f":null},{"v": 96,"f":null}]},
			        {"c":[{"v":"Apr","f":null},{"v": 80, "f":null},{"v": 49,"f":null},{"v": 88,"f":null}]},
			        {"c":[{"v":"May","f":null},{"v": 70, "f":null},{"v": 70,"f":null},{"v": 99,"f":null}]},
			        {"c":[{"v":"Jun","f":null},{"v": 78, "f":null},{"v": 60,"f":null},{"v": 80,"f":null}]},
			        {"c":[{"v":"Jul","f":null},{"v": 78, "f":null},{"v": 60,"f":null},{"v": 70,"f":null}]},
			        {"c":[{"v":"Aug","f":null},{"v": 58, "f":null},{"v": 40,"f":null},{"v": 60,"f":null}]},
			        {"c":[{"v":"Sep","f":null},{"v": 72, "f":null},{"v": 60,"f":null},{"v": 79,"f":null}]},
			        {"c":[{"v":"Oct","f":null},{"v": 68, "f":null},{"v": 70,"f":null},{"v": 89,"f":null}]},
			        {"c":[{"v":"Nov","f":null},{"v": 78, "f":null},{"v": 55,"f":null},{"v": 99,"f":null}]},
			        {"c":[{"v":"Dec","f":null},{"v": 58, "f":null},{"v": 40,"f":null},{"v": 80,"f":null}]},
			    ],
			    "p": {  }
		}';


    	return $data;


    }



    public function getDataWidgetFive(){

    	//
    	$queryResults = SensorsData::with('sensors')->where('el_sensor_id', 6)->get(['el_sensor_id','readOn','sensorData']); 
		$columnTwoLabel = $queryResults[0]->sensors->shortDescr;
    	

    	
		//foreach ($queryResults->first()->getAttributes() as $key => $value) {
			$cols_arr =  '{"id":"1","label":"Dates","pattern":"","type":"string"},';  // sostituire string con date (anche sopra)!
			$cols_arr .= '{"id":"2","label":"'. $columnTwoLabel .'","pattern":"","type":"number"},';
		//}
    	
		$rows_arr = '';

		foreach ($queryResults as $queryResult) {
			// dd($queryResult);
			$date = explode(' ', $queryResult->readOn)[0];  // $date = $date[0];
			$rows_arr .= '{"c":[{"v":"'.$date.'","f":null},{"v":'.$queryResult->sensorData.',"f":null}]},';
		}
    	
    	$cols = '"cols": [' . $cols_arr . '],';
    	$rows = '"rows": [' . $rows_arr . '],';
    	$data = '{'. $cols . $rows . '}'; 

    	
    	// DUMMY DATA PERCENTAGE
    	$data = '{   
			  	"cols": [
			        {"id":"A","label":"Departements","pattern":"","type":"string"},  
			        {"id":"B","label":"Consumption percentage","pattern":"","type":"number"},
			    ],
			  	"rows": [
			        {"c":[{"v":"Departement-1","f":null},{"v": 48, "f":null}, ]}, 
			        {"c":[{"v":"Departement-2","f":null},{"v": 12, "f":null}, ]},
			        {"c":[{"v":"Departement-3","f":null},{"v": 20, "f":null}, ]},
			        {"c":[{"v":"Departement-4","f":null},{"v":  5, "f":null}, ]},
			        {"c":[{"v":"Departement-5","f":null},{"v": 15, "f":null}, ]},
			    ],
			    "p": {  }
		}';


    	return $data;


    }



    public function getDataWidgetSix(){

    	//
    	$queryResults = SensorsData::with('sensors')->where('el_sensor_id', 6)->get(['el_sensor_id','readOn','sensorData']); 
		$columnTwoLabel = $queryResults[0]->sensors->shortDescr;
    	

    	
		//foreach ($queryResults->first()->getAttributes() as $key => $value) {
			$cols_arr =  '{"id":"1","label":"Dates","pattern":"","type":"string"},';  // sostituire string con date (anche sopra)!
			$cols_arr .= '{"id":"2","label":"'. $columnTwoLabel .'","pattern":"","type":"number"},';
		//}
    	
		$rows_arr = '';

		foreach ($queryResults as $queryResult) {
			// dd($queryResult);
			$date = explode(' ', $queryResult->readOn)[0];  // $date = $date[0];
			$rows_arr .= '{"c":[{"v":"'.$date.'","f":null},{"v":'.$queryResult->sensorData.',"f":null}]},';
		}
    	
    	$cols = '"cols": [' . $cols_arr . '],';
    	$rows = '"rows": [' . $rows_arr . '],';
    	$data = '{'. $cols . $rows . '}'; 

    	
    	// DUMMY DATA PERCENTAGE
    	$data = '{   
			  	"cols": [
			        {"id":"A","label":"Departements","pattern":"","type":"string"},  
			        {"id":"B","label":"Consumption percentage","pattern":"","type":"number"},
			    ],
			  	"rows": [
			        {"c":[{"v":"Departement-1","f":null},{"v": 48, "f":null}, ]}, 
			        {"c":[{"v":"Departement-2","f":null},{"v": 12, "f":null}, ]},
			        {"c":[{"v":"Departement-3","f":null},{"v": 20, "f":null}, ]},
			        {"c":[{"v":"Departement-4","f":null},{"v":  5, "f":null}, ]},
			        {"c":[{"v":"Departement-5","f":null},{"v": 15, "f":null}, ]},
			    ],
			    "p": {  }
		}';


    	return $data;


    }

    public function getDataWidgetSeven() {

    	//
    	$data = '123';


    	return $data;
    }



}
