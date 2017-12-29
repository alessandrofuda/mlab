<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use DB;


class MyTreeChartController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth'); 
    }



    public function my_tree(){

    	$myuser = User::find(Auth::user()->id);

    	if(!isset($myuser->node_id)) {

    		return 'error: node_id not set for this user.';
    	}
    	
    	$mynode = $myuser->node_id;
    	$subTree = DB::select('call subTree('.$mynode.')');


    	return view('my-tree', compact('subTree'));



    }



}
