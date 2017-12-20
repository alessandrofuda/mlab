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
    	$data = [
    			'cols' => [
    				'id' => '',
    				'label' => '',
    				'pattern' => '',
    				'type' => '',
    			],
    			'rows' => [
    				'c' => [
    						[
    						'v' => '',
    						'f' => '',
    						],
    						[
    						'v' => '',
    						'f' => '',
    						],
    					
    				],
    			],
    			];
    	
    	return response()->json($data);
    }


}
