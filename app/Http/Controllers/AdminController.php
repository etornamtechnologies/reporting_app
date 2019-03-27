<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('erole:admin');
    }

    public function getUsers(Request $request)
    {
        $result = [];
        try{
            $users = User::all();
            $result['code'] = 0;
            $result['users'] = $users;
        } catch(Exception $e) {
            $result['code'] = 1;
            $result['message'] = "Server error..please contact admin";
        }
        return response()->json($result);
    }


    public function getUser(Request $request, $id)
    {
        $result = [];
        try{
            $user = User::where('id', $id)->with('roles')->first();
            $result['code'] = 0;
            $result['user'] = $user;
        } catch(Exception $e) {
            $result['code'] = 1;
            $result['message'] = "Server error..please contact admin";
        }
        return response()->json($result);
    }

    public function assignRole(Request $request, $id)
    {
        try{
            $userId = $id;
            $input = $request->all();
            $myuser = User::findOrFail($userId);
            $myuser->roles()->detach();
            if($request->has('employee')) {
                $myuser->roles()->attach(Role::where('label', 'employee')->first());
            }
            if($request->has('admin')) {
                $myuser->roles()->attach(Role::where('label', 'admin')->first());
            }
            $result = [];
            $result['code'] = 0;
            $result['message'] = "roles updated";
            return response()->json($result);
        } catch(Exception $e) {
            $result['code'] = 1;
            $result['message'] = "Server error";
        }

    }
}
