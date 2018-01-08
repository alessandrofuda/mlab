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



    public function getDataWidgetOne() {
 
    	$sensors_arr = $this->getSensorsArray();
    	// return $sensors_arr;
    	
		// query "di default" --> all data of Auth user
		  
			

		// echo dropdownmenu of array sensors (meglio: elenco flaggabile individuarne alcuni di default)
    	// echo dropdownmenu of "today", "last week", "last month", "last 30 days".
    	// query "di affinamento"
    	
		
    	/* ----------- BLOCCO COLS ---------------------- */
    	$queryCols = SensorsData::with('sensors.sensorsDescriptor')->whereIn('el_sensor_id', $sensors_arr)->groupBy('el_sensor_id')->get(['el_sensor_id','sensorData']);
    	$cols_arr = '';
		$cols_arr .=  '{"id":"day","label":"Days","pattern":"","type":"date"},';
		foreach ($queryCols as $queryCol) {
		  	$cols_arr .= '{"id":"sensor-'.$queryCol->el_sensor_id.'","label":"'.$queryCol->sensors->sensorsDescriptor->shortDescr.'","pattern":"","type":"number"},';
		}  
		// return $cols_arr;
		/* ------------- FINE BLOCCO COLS ------------------ */
    	
    	
    

    	/*--------------- BLOCCO ROWS ------------------- */
		$sensorsData = DB::table('vl_sensorsData')->whereIn('el_sensor_id', $sensors_arr);
				
		$dates_arr_obj = $sensorsData->select(DB::raw('Date(createdOn) as createdOn'))
									->get();
									// return $dates_arr_obj;  // array of objects
		$dates_arr = [];
		foreach ($dates_arr_obj as $value) {
			//return $value->createdOn;
			$dates_arr[] = $value->createdOn;
		}
		$dates_arr = array_unique($dates_arr, SORT_REGULAR);  // ['2018-12-02', '2018-12-03', ...]
		//return $dates_arr;
		
		$rows_arr = '';
		foreach ($dates_arr as $date) {
			
			if(isset($date)) {
				// $date_str = explode(' ', $date)[0];  // $date = $date[0];
				//$time = explode(' ', $vps_subarray->createdOn)[1];
				$date_arr = explode('-', $date); 
				//$time = explode(':', $time);
				$yyyy = $date_arr[0];
				$mm = $date_arr[1];
				$dd = $date_arr[2];
				//$hh = $time[0];
				//$mm = $time[1];
			} else {
				$yyyy = null;
				$mm = null;
				$dd = null;
			}

			$sub_string = '';
			
			foreach ($sensors_arr as $sensor) {  // $sensors_arr = [5,6,7,31, ... ]
				// re-init $value

				$value = [];
				//$date = '2018-01-02';
				$value = $sensorsData->select('el_sensor_id', 'createdOn', DB::raw('max(sensorData) - min(sensorData) as kWh_day'))
									->groupBy(['el_sensor_id', DB::raw('Date(createdOn)')])   
									->orderBy('el_sensor_id', 'ASC')
									->orderBy('createdOn', 'ASC')
									->where('createdOn', 'like', '%'.$date.'%')     // 00:00:00')
									->where('el_sensor_id', $sensor)
									->get()
									//->first()
									;
				// return $value;
				// return $value[0]->kWh_day;
				$v = isset($value[0]) ? $value[0]->kWh_day : 'null';		
				$sub_string .= '{"v":'.$v.',"f":null},';
				// return $sub_string;
			} 
			//return $sub_string;

			$rows_arr .= '{"c":[{"v":"Date('.$yyyy.', '.$mm.', '.$dd.')","f":null},'.$sub_string.']},';
		}

		return $rows_arr;

		/*
		$rows_arr = '';
		foreach ($values_per_sensors as $values_per_sensor) {

			//return $values_per_sensor;
			
			$sub_array = '';
			foreach ($values_per_sensor as $vps_subarray) {

				// subArray for values: foreach
				$sub_array = '';
				//return $vps_subarray;
				foreach ($queryCols as $value) {
					$sub_array .= '{"v":'.$vps_subarray->kWh_day.',"f":null},';
				}					
			


				if(isset($vps_subarray->createdOn)) {
					$date = explode(' ', $vps_subarray->createdOn)[0];  // $date = $date[0];
					//$time = explode(' ', $vps_subarray->createdOn)[1];
					$date = explode('-', $date); 
					//$time = explode(':', $time);
					$yyyy = $date[0];
					$mm = $date[1];
					$dd = $date[2];
					//$hh = $time[0];
					//$mm = $time[1];
				} else {
					$yyyy = null;
					$mm = null;
					$dd = null;
				}

			$rows_arr .= '{"c":[{"v":"Date('.$yyyy.', '.$mm.', '.$dd.')","f":null},'.$sub_array.']},';

			//return $rows_arr;


			}
			
		} */

		//return $rows_arr;
		/* ---------------- FINE BLOCCO ROWS ------------------ */




		// !!!!! SISTEMARE, PRODUCE UNA SERIE DI QUESTO TIPO (SBAGLIATA perchè fa il merge di sensor 5 e 6)
		/*
{"c":[{"v":"Date(2018, 15, 02, 19, 15)","f":null},{"v":4653,"f":null},{"v":4653,"f":null},]},
{"c":[{"v":"Date(2018, 30, 02, 19, 30)","f":null},{"v":4653,"f":null},{"v":4653,"f":null},]},
{"c":[{"v":"Date(2018, 45, 02, 19, 45)","f":null},{"v":4653,"f":null},{"v":4653,"f":null},]},
{"c":[{"v":"Date(2018, 00, 02, 20, 00)","f":null},{"v":4653,"f":null},{"v":4653,"f":null},]},  <--- vedi orario
{"c":[{"v":"Date(2018, 00, 02, 20, 00)","f":null},{"v":4653,"f":null},{"v":4653,"f":null},]},
{"c":[{"v":"Date(2018, 15, 02, 20, 15)","f":null},{"v":4653,"f":null},{"v":4653,"f":null},]},
{"c":[{"v":"Date(2018, 30, 02, 20, 30)","f":null},{"v":4653,"f":null},{"v":4653,"f":null},]},
{"c":[{"v":"Date(2018, 45, 02, 20, 45)","f":null},{"v":4653,"f":null},{"v":4653,"f":null},]},
{"c":[{"v":"Date(2018, 00, 02, 21, 00)","f":null},{"v":4653,"f":null},{"v":4653,"f":null},]},  <--- vedi orario
{"c":[{"v":"Date(2018, 00, 02, 21, 00)","f":null},{"v":4653,"f":null},{"v":4653,"f":null},]},
*/







    	
    	$cols = '"cols": [' . $cols_arr . '],';
    	$rows = '"rows": [' . $rows_arr . '],';
    	$data = '{'. $cols . $rows . '}'; 



    	// DUMMY   "type":"date"  -->> v: "Date(2018, 01, 03)" 
											    				/* {"id":"sensor-31","label":"Sensor-31","pattern":"","type":"number"},
														        {"id":"sensor-32","label":"Sensor-32","pattern":"","type":"number"},
														        {"id":"sensor-33","label":"Sensor-33","pattern":"","type":"number"},
														        {"id":"sensor-34","label":"Sensor-34","pattern":"","type":"number"},
														        {"id":"sensor-35","label":"Sensor-35","pattern":"","type":"number"},
														        {"id":"sensor-36","label":"Sensor-36","pattern":"","type":"number"},
														        {"id":"sensor-37","label":"Sensor-37","pattern":"","type":"number"},
														        {"id":"sensor-38","label":"Sensor-38","pattern":"","type":"number"}, */

    	$data = '{   
			  	"cols": [
			        {"id":"day","label":"Days","pattern":"","type":"date"},  
			        {"id":"sensor-5","label":"Sensor-5","pattern":"","type":"number"}, 
			        {"id":"sensor-6","label":"Sensor-6","pattern":"","type":"number"},
			        {"id":"sensor-7","label":"Sensor-7","pattern":"","type":"number"},
			    ],    

			    
			  	"rows": [										
			        {"c":[{"v":"Date(2017, 12, 01)","f":null},{"v": 88, "f":null},{"v": 99,"f":null},{"v": 85,"f":null}]}, 
			        {"c":[{"v":"Date(2017, 12, 02)","f":null},{"v": 90, "f":null},{"v": 95,"f":null},{"v": 75,"f":null}]},
			        {"c":[{"v":"Date(2017, 12, 03)","f":null},{"v": 95, "f":null},{"v": 84,"f":null},{"v": 96,"f":null}]},
			        {"c":[{"v":"Date(2017, 12, 04)","f":null},{"v": 80, "f":null},{"v": 49,"f":null},{"v": 88,"f":null}]},
			        {"c":[{"v":"Date(2017, 12, 05)","f":null},{"v": 70, "f":null},{"v": 70,"f":null},{"v": 99,"f":null}]},
			        {"c":[{"v":"Date(2017, 12, 06)","f":null},{"v": 78, "f":null},{"v": 60,"f":null},{"v": 80,"f":null}]},
			        {"c":[{"v":"Date(2017, 12, 07)","f":null},{"v": 78, "f":null},{"v": 60,"f":null},{"v": 70,"f":null}]},
			        {"c":[{"v":"Date(2017, 12, 08)","f":null},{"v": 58, "f":null},{"v": 40,"f":null},{"v": 60,"f":null}]},
			        {"c":[{"v":"Date(2017, 12, 09)","f":null},{"v": 72, "f":null},{"v": 60,"f":null},{"v": 79,"f":null}]},
			        {"c":[{"v":"Date(2017, 12, 10)","f":null},{"v": 68, "f":null},{"v": 70,"f":null},{"v": 89,"f":null}]},
			        {"c":[{"v":"Date(2017, 12, 11)","f":null},{"v": 78, "f":null},{"v": 55,"f":null},{"v": 99,"f":null}]},
			        {"c":[{"v":"Date(2017, 12, 12)","f":null},{"v": 58, "f":null},{"v": 40,"f":null},{"v": 80,"f":null}]},
			    ],
			    "p": {  }
		}';


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
			$date = explode(' ', $queryResult->readOn)[0];  // $date = $date[0];
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
