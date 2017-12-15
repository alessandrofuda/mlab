<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
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


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($current_dashboard = 1)
    {
        $title = 'My Dashboard ' . $current_dashboard;
        $widgets = UserDashboardWidget::where('user_id', Auth::user()->id)
                                        ->where('dashboard_id', $current_dashboard)
                                        ->with('widgets')
                                        ->get();
        
        return view('home', compact('title', 'current_dashboard', 'widgets'));
    }
    

    /**
     * Display Auth user profile
     *
     * 
     */
    public function my_profile()
    {
        $title = 'My Profile';
        return view('my-profile', compact('title'));
    }


    /**
    *   Change Auth user password
    *
    */
    public function change_my_psw()
    {
        $title = 'Change password';
        return view('change-my-psw', compact('title'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
