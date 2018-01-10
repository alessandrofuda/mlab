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
    	$aggregationLevel = 'Date(createdOn)';  // daily
    	//$aggregationLevel = 'Month(createdOn)'; //monthly
		$startDate = '';
		$endDate = '';



    	/* ----------- BLOCCO COLS ---------------------- */
    	$queryCols = SensorsData::with('sensors.sensorsDescriptor')->whereIn('el_sensor_id', $sensors_arr)
    															   ->groupBy('el_sensor_id')
    															   ->get(['el_sensor_id','sensorData']);
    	//return $queryCols;
    	$cols_arr = '';
		$cols_arr .=  '{"id":"day","label":"Days","pattern":"","type":"date"},';
		foreach ($queryCols as $queryCol) {
		  	$cols_arr .= '{"id":"sensor-'.$queryCol->el_sensor_id.'","label":"'.$queryCol->sensors->sensorsDescriptor->shortDescr.'","pattern":"","type":"number"},';
		}  
		// return $cols_arr;
		/* ------------- FINE BLOCCO COLS ------------------ */


    	/*--------------- BLOCCO ROWS ------------------- */
		$rows_arr = '';

		// ---> array DATES/TIMES
		$dates_obj = SensorsData::whereIn('el_sensor_id', $sensors_arr)
								//->where('createdOn', '>=', '%'.$startDate.'%')
								//->where('createdOn', '<=', '%'.$endDate.'%')
								->groupBy(DB::raw( $aggregationLevel ))
								->get([DB::raw('Date(createdOn) as date')]);
		$dates = [];
		foreach ($dates_obj as $date_item) {
			$dates[] = $date_item->date;   // ["2018-01-02", "2018-01-03", "2018-01-04"]
		}
return $dates;

		// ---> array SENSORS (realmente presenti in DB!->important!)
		$sensors_obj = SensorsData::whereIn('el_sensor_id', $sensors_arr)
								  ->groupBy('el_sensor_id')
								  ->get(['el_sensor_id']);
		$sensors = [];
		foreach ($sensors_obj as $sensor_item) {
			$sensors[] = $sensor_item->el_sensor_id;
		}

		
		// ---> MAIN QUERY
		foreach ($dates as $date) {
			$sensors_values = '';
			foreach ($sensors as $sensor) {
				
				$value = SensorsData::groupBy(DB::raw('Date(createdOn)'), 'el_sensor_id')
									->where('createdOn', 'LIKE', '%'.$date.'%')
									->where('el_sensor_id', $sensor)
									//->select('createdOn', 'el_sensor_id', DB::raw('SUM(sensorData) as sum'))
									->select(DB::raw('SUM(sensorData) as sum'))
									//->get()
									->first()
									->sum;
									//return $value;

				$sensors_values .= '{"v": '.$value.', "f":null},'; // qui impostare query .. $sensor->value
				// return $sensors_values;
			}
			//return $sensors_values;
			$expl_date = explode('-', $date);
			$yyyy = $expl_date[0];
			$mm = $expl_date[1] - 1;  // in js date object, months era indexed starting at zero and go up to eleven !
			$dd = $expl_date[2];
			$rows_arr .= '{"c":[{"v":"Date('.$yyyy.', '.$mm.', '.$dd.')","f":null}, '.$sensors_values. ']}, ';
		}
		// return $rows_arr;
		/* ---------------- FINE BLOCCO ROWS ------------------ */

    	
    	// ---> CREATE JSON DATA
    	$cols = '"cols": [' . $cols_arr . '],';
    	$rows = '"rows": [' . $rows_arr . '],';
    	$data = '{'. $cols . $rows . '}'; 



    	/* $data = '{   
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
		}'; */


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
