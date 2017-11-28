<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\User;
use Session;


class AdminController extends Controller
{
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
            'name' => 'required',
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
            
                // redirect
                return Redirect::to('admin/users')->with('success-message', 'L\'utente <b>'.$request->name.'</b> è stato creato correttamente');
            } else {
                return Redirect::back()->with('error-message', 'Si è verificato un problema con la creazione del nuovo utente');
            }
        }
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

}
