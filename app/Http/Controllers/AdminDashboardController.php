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



    /**
    *
    * Se si creano nuovi widgets o dashboards --> li aggiunge agli utenti già creati in precedenza (new records in UserDashboardWidget).
    * [ONLY add records that don't already exist. If already exist NOT update.]
    * --> Loop between ALL USERS
    */
    public function updateUserDashboardWidgetAllUsers(){  // $user_id
        
        $users = User::get(['id']);
        $dashboards = Dashboard::get(['id']);               //all();
        $widgets = Widget::get(['id']);         //all();
        

        // dd($widgets[0]->id);
        $i = 0;
        foreach ($users as $user) {
            foreach ($dashboards as $dashboard) {
                foreach ($widgets as $widget) {
                    
                    $dashboardProfile = UserDashboardWidget::firstOrCreate([
                        'user_id' => $user->id,
                        'dashboard_id' => $dashboard->id, 
                        'widget_id' => $widget->id,
                    ]);

                    if ($dashboardProfile->wasRecentlyCreated) {
                        // "firstOrCreate" didn't find the user in the DB, so it created it.
                        $dashboardProfile->fill([
                            'x' => 0,
                            'y' => 0,
                            'width' => 1,
                            'height' => 1,
                            'active' => false,
                        ]);

                        $i++;

                    } // else {
                        // "firstOrCreate" found the user in the DB and fetched it.

                    //}
                    
                }
            }
        }
        
        return Redirect::back()->with('success-message', '[Admin notification] OK: \'lr_user_dashboard_widget\' table updated correctly. <b>'.$i.'</b> new records created.');

    }
    

}
