<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;


class RoleAssignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user() == null && Auth::user()->can('roleAndPermission-view')){
        $users = User::paginate(15);
        $roles = Role::all();
        return view('livewire.roles-assign', compact('users', 'roles'));
        } else {
            session()->flash('message', 'You are not able to go through!');
            return redirect()->back();        
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user() == null && Auth::user()->can('roleAndPermission-create')){
            $users = User::get();
            $roles = Role::all();
            return view('livewire.new-roles-assign', compact('users', 'roles'));
        } else {
            session()->flash('message', 'You are not able to go through!');
            return redirect()->back();        
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
        if (!Auth::user() == null && Auth::user()->can('roleAndPermission-create')){
            $user = new User();
            $user = User::where('id',$request->uid)->first();
            if ($request->roles) {
                $user->assignRole($request->roles);
            }
            session()->flash('message', 'Successfully Role Assigned');
            return redirect()->route('roles-assign.index');
        } else {
            session()->flash('message', 'You are not able to go through!');
            return redirect()->back();        
        }
        // $user->save();

        // $user->roles()->detach();
        // if ($data->roles) {
        //     $user->assignRole($data->roles);
        // }
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
        if (!Auth::user() == null && Auth::user()->can('roleAndPermission-edit')){
            $user = User::find($id);
            $roles  = Role::all();
            return view('livewire.edit-role-assign', compact('user', 'roles'));
        } else {
            session()->flash('message', 'You are not able to go through!');
            return redirect()->back();        
        }
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
        if (!Auth::user() == null && Auth::user()->can('roleAndPermission-create')){
            $user = User::find($id);
            $user->roles()->detach();
            if ($request->roles) {
                $user->assignRole($request->roles);
            }
            session()->flash('message', 'Successfully Role Assigned Updated!');
            return redirect()->route('roles-assign.index');
        } else {
            session()->flash('message', 'You are not able to go through!');
            return redirect()->back();        
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
        if (!Auth::user() == null && Auth::user()->can('roleAndPermission-create')){
            return redirect()->route('roles-assign.index');
        } else {
            session()->flash('message', 'You are not able to go through!');
            return redirect()->back();        
        }
    }
}
