<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;
use App\Instrument;
use App\Actuator;
use App\Customer;
use App\Machine;
use App\Sensor;
use App\Plant;
use App\Node;
use App\User;
use Auth;
use DB;


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



    /**
    *	show complete Tree of nodes of all users/customers
    *
    *
    **/
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
		$rows_arr = '{"c":[{"v":"0","f":"<b>ICE</b>"},{"v":"","f":""},{"v":"ICE","f":""}]},';
		foreach ($nodes as $node) {

			$node_descr = $node->stType->shortDescr;

			$type_id = $node->df_stType_id;
			$node_id = $node->id;
			$node_name = $this->match_TypeId_Model($type_id, $node_id);
			
			$rows_arr .= '{"c":[{"v":"'.$node_id.'","f":"<xx-small>'.$node_descr.':</xx-small><br><b>'.$node_name.'</b>"},{"v":"'.$node->parentId.'","f":""},{"v":"tootltips","f":""}]},';
		}


		$cols = '"cols": [' . $cols_arr . '],';
    	$rows = '"rows": [' . $rows_arr . '],';
    	$data = '{'. $cols . $rows . '}';

	
    	return $data;

    }



    /**
    *	show subTree nodes of a singular user
    *
    *
    */
    public function getDataMyTreechart(){


    	$myuser = User::find(Auth::user()->id);

    	if(!isset($myuser->node_id)) {

    		return 'error: node_id not set for this user.';
    	}
    	
    	$mynode = $myuser->node_id;
    	$subTree = DB::select('call subTree('.$mynode.')');
    	$subNodes = [];
    	$subNodes[] = $mynode;  // add current node Id to all subTree Ids   /////////////////////////////////////
    	foreach ($subTree as $subNode) {
    		$subNodes[] = $subNode->id;
    	}

    	$nodes = Node::with('stType')->whereIn('id', $subNodes)->get();

		
		$cols_arr = '{"id":"node","label":"Node","type":"string"},
		        	 {"id":"parent","label":"Parent","type":"string"},
		        	 {"id":"tooltip","label":"Tooltip","type":"string"}';

		
		$rows_arr = '';
		$mynode_name = 'My Node';
		//$rows_arr .= '{"c":[{"v":"'.$mynode.'","f":"<b>'.$mynode_name.'</b>"},{"v":"","f":""},{"v":"tooltip","f":"'.$mynode_name.'"}]},'; //////////////
		foreach ($nodes as $node) {

			$node_descr = $node->stType->shortDescr;

			$type_id = $node->df_stType_id;
			$node_id = $node->id;
			$node_name = $this->match_TypeId_Model($type_id, $node_id);
			$parentId = $node->parentId ? : '';
			
			$rows_arr .= '{"c":[
								{"v":"'.$node_id.'","f":"'.$node_id.'<br><xx-small>'.$node_descr.':</xx-small><br><b>'.$node_name.'</b>"},
								{"v":"'.$parentId.'","f":""},
								{"v":"tootltips","f":"'.$node_name.'"}
							]},';
		}


		$cols = '"cols": [' . $cols_arr . '],';
    	$rows = '"rows": [' . $rows_arr . '],';
    	$data = '{'. $cols . $rows . '}';

	
    	return $data;


    }



    /**
    * Match 'df_stType_id' of 'stNodes' table to fetch right 'shortDescr' fields
    *
    * return $node_name (i.e: 'shortDescr' fields)
    */
    public function match_TypeId_Model($type_id, $node_id){

    	if ($type_id == 1) {
				//$Model = 'Customer';
				$node_name = Customer::find($node_id)->shortDescr;
			} elseif ($type_id == 2) {
				//$Model = 'Plant';
				$node_name = Plant::find($node_id)->shortDescr;
			} elseif ($type_id == 3) {
				//$Model = 'Department';
				$node_name = Department::find($node_id)->shortDescr;
			} elseif ($type_id == 4) {
				//$Model = 'Instrument';
				$node_name = Instrument::find($node_id)->shortDescr;
			} elseif ($type_id == 5) {
				//$Model = 'Machine';
				$node_name = Machine::find($node_id)->shortDescr;
			} elseif ($type_id == 6) {
				//$Model = 'Sensor';
				$node_name = Sensor::find($node_id)->shortDescr;
			} elseif ($type_id == 7) {
				//$Model = 'Actuator';
				$node_name = Actuator::find($node_id)->shortDescr;
			} else {
				return 'error: df_stType_id not found..';
			}

			return $node_name;

    }



}
