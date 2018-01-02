<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Node;
use App\Customer;
use App\Plant;
use App\Department;
use App\Instrument;
use App\Machine;
use App\Sensor;
use App\Actuator;


class AjaxTreeController extends Controller
{
    //
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    { 
        $this->middleware('ajax');  
    }



    public function getDataTreechart(){ 


    	// basic data model
		/* $data ='{
		  	"cols": [
		        {"id":"node","label":"Node","type":"string"},
		        {"id":"parent","label":"Parent","type":"string"},
		        {"id":"tooltip","label":"Tooltip","type":"string"}
		    ],
		  	"rows": [
		        {"c":[{"v":"NodeA","f":""},{"v":"","f":""},{"v":"NodeA","f":""}]},
		        {"c":[{"v":"NodeB","f":""},{"v":"NodeA","f":""},{"v":"NodeA","f":""}]},
		        {"c":[{"v":"NodeC","f":""},{"v":"NodeA","f":""},{"v":"NodeA","f":""}]},
		        {"c":[{"v":"NodeD","f":""},{"v":"NodeC","f":""},{"v":"NodeA","f":""}]},
		    ],
		}'; */
		$nodes = Node::with('stType')->get();
		
		$cols_arr = '{"id":"node","label":"Node","type":"string"},
		        	 {"id":"parent","label":"Parent","type":"string"},
		        	 {"id":"tooltip","label":"Tooltip","type":"string"}';

		
		$rows_arr = '';
		$rows_arr = '{"c":[{"v":"0","f":"ICE"},{"v":"","f":""},{"v":"ICE","f":""}]},';
		foreach ($nodes as $node) {
			$node_descr = $node->stType->shortDescr;



			$type_id = $node->df_stType_id;

			if ($type_id == 1) {
				$Model = 'Customer';
				$node_name = Customer::find($node->id)->shortDescr;
			} elseif ($type_id == 2) {
				$Model = 'Plant';
				$node_name = Plant::find($node->id)->shortDescr;
			} elseif ($type_id == 3) {
				$Model = 'Department';
				$node_name = Department::find($node->id)->shortDescr;
			} elseif ($type_id == 4) {
				$Model = 'Instrument';
				$node_name = Instrument::find($node->id)->shortDescr;
			} elseif ($type_id == 5) {
				$Model = 'Machine';
				$node_name = Machine::find($node->id)->shortDescr;
			} elseif ($type_id == 6) {
				$Model = 'Sensor';
				$node_name = Sensor::find($node->id)->shortDescr;
			} elseif ($type_id == 7) {
				$Model = 'Actuator';
				$node_name = Actuator::find($node->id)->shortDescr;
			} else {
				return 'error: df_stType_id not found..';
			}

			

			$rows_arr .= '{"c":[{"v":"'.$node->id.'","f":"<xx-small>'.$node_descr.':</xx-small><br>'.$node_name.'"},{"v":"'.$node->parentId.'","f":""},{"v":"tootltips","f":""}]},';
		}


		$cols = '"cols": [' . $cols_arr . '],';
    	$rows = '"rows": [' . $rows_arr . '],';
    	$data = '{'. $cols . $rows . '}';

	
    	return $data;

    }



}
