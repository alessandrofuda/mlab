<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\UserDashboardWidget;
use App\Dashboard;
use App\Widget;
use App\User;
use Session;


class AdminController extends Controller
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
    public function dashboard()
    {   
        $title = 'My Admin Dashboard';
        $widgets = UserDashboardWidget::where('user_id', Auth::user()->id)->with('widgets')->get();

        // dd($widgets);

        return view('admin.home', compact('title', 'widgets')); 
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {   
        // validation form
        $rules = array(
            'name' => 'required|string|unique:lr_users',
            'email'=> 'required|email',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        } else {
            // store
            $role = $request->admin == true ? 1 : 0;
            $actuator = $request->actuator == true ? 1 : 0;

            if( User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'is_admin' => $role,
                'is_actuator' => $actuator
            ]) ) {


                // create default widgets profile
                // $user_id = ... ;
                // $this->init_widgets($user_id);
            

                // redirect
                return Redirect::to('admin/users')->with('success-message', 'L\'utente <b>'.$request->name.'</b> è stato creato correttamente');
            } else {
                return Redirect::back()->with('error-message', 'Si è verificato un problema con la creazione del nuovo utente');
            }
        }
    }



    /**
    *  Cread "gruppo widget" di default alla creazione di ogni nuovo utente 
    *
    *
    */
    public function init_widgets($user_id){

        // store defaults widgets configuration in db

        $widgets = Widget::all();

        // dd($widgets[0]->id);

        foreach ($widgets as $widget) {
            
            $default_widgets = UserDashboardWidget::updateOrCreate([
                'user_id' => $user_id,
                'dashboard_id' => 1,
                'widget_id' => $widget->id,
                'x' => 0,
                'y' => 0,
                'width' => 1,
                'height' => 1,
                'active' => false,
            ]);
        }

        // return to $this->create()
        return;  // true;  // ???

    }





    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // validation form
        $rules = array(
            'name' => 'string|required',
            'email' => 'email|required'
        );

        if (isset($request->password)) { 
            $rules = array_merge($rules, ['password' => 'required|string|min:6|confirmed']);
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        } else {
            // store
            $role = $request->admin == true ? 1 : 0;
            $actuator = $request->actuator == true ? 1 : 0;

            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->is_admin = $role;
            $user->is_actuator = $actuator;
            
            if (isset($request->password)) {
               $user->password = bcrypt($request->password);
            }
            
            $user->save();

            // redirect
            return Redirect::to('admin/users')->with('success-message', 'Utente aggiornato correttamente');
        }

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $user = User::find($id);
        $user->delete();

        return Redirect::to('admin/users')->with('success-message', 'Utente cancellato correttamente');
    }

    /**
    * reimposta password utente lato admin
    */
    public function reset_psw(Request $request, $id) //     SISTEMARE INTEGRARE CON L'UPDATE FUNC
    {
        // validation form
        $rules = array(
            'password' => 'required|string|min:6|confirmed',
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        } else {
            // store new psw
            $user = User::find($id);
            $user->password = $request->password; // bcrypt()            
            $user->save();

            // redirect
            return Redirect::to('admin/users')->with('success-message', 'Password modificata correttamente');
        }
    }


    /**
    *   Dashboard Customization
    *
    *
    */
    public function dashboards_customization()
    {
        $title = 'Dashboards customization';

        return view('admin.dashboards_customization', compact('title'));
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
