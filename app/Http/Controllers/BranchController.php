<?php

namespace App\Http\Controllers;

use App\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $branches = Branch::with(['user'])->get();
            return response()->json(['code'=> 0, 'branches'=> $branches]);
        } catch(Exception $e) {
            return response()->json(['code'=>1, 'message'=> 'Server error']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'label'=> 'required|unique:branches',
        ]);
        try {
            $branch = Branch::create([
                'label'=> $request->label,
                'user_id'=> Auth::user()->id
            ]);
            $b = Branch::where('id', $branch->id)->with('user')->first();
            return response()->json(['code'=> 0, 'branch'=> $b, 'message'=>'branch created successfully']);
        } catch(Exception $e) {
            return response()->json(['code'=>1, 'message'=> 'Server error']);
        }
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
        $request->validate([
            'label'=>'required|unique:branches,label,'.$id.'id',
        ]);
        try {
            $branch = Branch::where('id', $id)
                                ->update([
                                    'label'=> $request->label,
                                    'user_id'=> Auth::user()->id
                                ]);
            $b = Branch::where('id', $id)->with('user')->first();
            return response()->json(['code'=> 0, 'branch'=> $b, 'message'=>'branch updated successfully']);
        } catch(Exception $e) {
            return response()->json(['code'=>1, 'message'=> 'Server error']);
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
        Branch::destroy($id);
        return response()->json(['code'=> 0]);
    }
}
