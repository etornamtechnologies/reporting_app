<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('erole:admin', ['except'=> ['index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $companies = Company::with('user')->get();
            return response()->json(['code'=>0, 'companies'=>$companies]);
        } catch(Exception $e) {
            return response()->json(['code'=>1, 'message'=>'Server error']);
        }
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'label'=> 'required|unique:companies',
        ]);
        $file = null;
        if($request->hasFile('logo')) {
            $file = $request->file('logo');
        }
        try {
            $company = Company::create([
                'label' => $request->label,
                'user_id'=> Auth::user()->id,
            ]);
            $c = Company::where('id', $company->id)->with('user')->first();
            return response()->json(['code'=>0, 'company'=>$c, 'message'=> 'company created successfully']);
        } catch(Exception $e) {
            return response()->json(['code'=> 1, 'message'=>'Server error']);
        }
    }

    
    public function show($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'label'=> 'required|unique:companies, label, '.$id.'id',
        ]);
        $file = null;
        if($request->hasFile('logo')) {
            $file = $request->file('logo');
        }
        try {
            $company = Company::where('id', $id)->update([
                'label' => $request->label,
                'user_id'=> Auth::user()->id,
            ]);
            return response()->json(['code'=>0, 'message'=>'company updated']);
        } catch(Exception $e) {
            return response()->json(['code'=> 1, 'message'=>'Server error']);
        }
    }

    public function destroy($id)
    {
        Company::destroy($id);
        return response()->json(['code'=>0, 'message'=> 'company deleted successfully']);
    }
}
