<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\UserDashboardWidget;
use App\Dashboard;
use App\Widget;
use App\User;
use Session;


class AdminDashboardController extends Controller
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



    /**
    * 
    */
    public function dashboard($current_dashboard = 1)
    {   
        // dd($current_dashboard);
        $title = 'My Admin Dashboard '. $current_dashboard;
        $widgets = UserDashboardWidget::where('user_id', Auth::user()->id)
                                        ->where('dashboard_id', $current_dashboard)
                                        ->with('widgets')
                                        ->get();

        // dd($widgets);
        // dd($current_dashboard);

        return view('admin.home', compact('title', 'current_dashboard', 'widgets')); 
    }




    /**
    *   Dashboard Customization
    *
    *
    */
    public function dashboards_customization()
    {
        $title = 'Dashboards customization';
        $users = User::get(['id', 'name']);
        // dd($users);

        return view('admin.dashboards_customization', compact('title', 'users'));
    }




    public function dashboards_customization_post(Request $request){

        $user_id = $request->user;
        $dashboard_id = $request->dashboard;
        
        // dd($current_dashboard);
        $title = 'Dashboards customization';
        $sub_title = '<p>User: '.User::find($user_id)->name.'</p><p>Dashboard: '.$dashboard_id.'</p>';
        $users = User::get(['id','name']);  //all();
        $current_dashboard = $dashboard_id;
        $current_user = $user_id;
        $widgets = UserDashboardWidget::where('user_id', $user_id)
                                        ->where('dashboard_id', $dashboard_id)
                                        ->with('widgets')
                                        ->get();

        // dd($widgets);

        return view('admin.dashboards_customization', compact('title', 'sub_title', 'users', 'current_dashboard', 'current_user', 'widgets')); 


    }


    /**
    *   Export Data section
    *
    *
    */
    public function exports()
    {
        $title = 'Exports Data';

        return view('admin.exports_data', compact('title'));
    }



    
}
