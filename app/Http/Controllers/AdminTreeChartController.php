<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    	//
    	$node_id = 3;

    	$subTree = DB::select('call subTree('.$node_id.')');

    	return view('admin.treechart', compact('subTree'));

    }
}
