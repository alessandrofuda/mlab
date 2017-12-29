<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Node;
use DB;


class AdminTreeChartController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin'); 
    }



    public function tree_chart() {

    	// TEST
    	$node_id = 3;




    	$title = 'Tree Chart';
    	

    	$subTree = DB::select('call subTree('.$node_id.')');
    	$subNodes = [];
    	foreach ($subTree as $subNode) {
    		$subNodes[] = $subNode->id;
    	}
    	
    	// dd($subNodes);

    	$nodes = Node::with('stType')->whereIn('id', $subNodes)->get();
    	//dd($nodes);



    	return view('admin.treechart', compact('title','node_id','nodes'));

    }
}
