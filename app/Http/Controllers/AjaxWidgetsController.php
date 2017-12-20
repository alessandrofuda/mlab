<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SensorsData;
use App\Sensor;



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

    	// giusta formattazione da ottenre dalla query e restituire in json
    	/* $data_test = '{   
		  "cols": [
		        {"id":"","label":"Dates","pattern":"","type":"string"},  
		        {"id":"","label":"Hourly Energy","pattern":"","type":"number"},
		      ],
		  "rows": [
		        {"c":[{"v":"data1","f":null},{"v":9,"f":null}]},
		        {"c":[{"v":"data2","f":null},{"v":8,"f":null}]},
		        {"c":[{"v":"data3","f":null},{"v":6,"f":null}]},
		        {"c":[{"v":"data4","f":null},{"v":9,"f":null}]},
		        {"c":[{"v":"data5","f":null},{"v":10,"f":null}]},
		      ]
		}';
		*/

		// return $data_test;

		
		$queryResults = SensorsData::with('sensors')->where('el_sensor_id', 5)->get(['el_sensor_id','readOn','sensorData']);  //->lists()DEPREC. -> pluck()  // ->get(); 
    	// return response()->json($queryResults); // !!  also can use the facade
    	$columnTwoLabel = $queryResults[0]->sensors->shortDescr;
		//foreach ($queryResults->first()->getAttributes() as $key => $value) {
			$cols_arr =  '{"id":"1","label":"Dates","pattern":"","type":"string"},';  // sostituire string con date (anche sotto)!
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



}
