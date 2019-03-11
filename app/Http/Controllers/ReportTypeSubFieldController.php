<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ReportField;

class ReportTypeSubFieldController extends Controller
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
        //
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
        $input = $request->all();
        $result = [];
        $request->validate([
            'label'=> 'required',
            'num'=>'required',
            'den'=> 'required',
            'id'
        ]);
        try {
            $field = ReportField::create([
                'label'=> $input['label'],
                'report_type_id'=> $input['id'],
                'approve'=> $input['approve'],
                'numerator'=>$input['num'],
                'denumerator'=> $input['den']
            ]);
            $result = [];
            $result['code'] = 0;
            $result['field'] = $field;
        } catch(Exception $e) {
            $result['code'] = 1;
            $result['message'] = "Server error! Please contact admin";
        }
        return response()->json($result);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = [];
        try {
            ReportField::destroy($id);
            $result = ['code'=>0];
        } catch(Exception $e) {
            $result['code'] = 1;
            $result['message'] = "Server error! Please contact admin";
        }
        return response()->json($result);
    }
}
