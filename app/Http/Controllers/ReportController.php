<?php

namespace App\Http\Controllers;

use App\Report;
use App\ReportType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {
        $result = [];
        try {
            $reports = Report::orderBy('created_at', 'desc')->with(['user','branch','company'])->get();
            $result['code']= 0;
            $result['reports'] = $reports;
        } catch(Exception $e) {
            $result['code'] = 1;
            $result['message'] = 'server error';
        }
        return response()->json($result);                
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('report.create');
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
        $request->validate([
            'label'=> 'required',
            'company_id'=> 'required',
            'branch_id'=> 'required',
        ]);
        $report = Report::create([
            'label'=> $input['label'],
            'company_id'=> $input['company_id'],
            'branch_id'=> $input['branch_id'],
            'user_id'=> Auth::user()->id
        ]);
        $result = [];
        if($report) {
            $result['code'] = 0;
            $result['message']= 'report created successfully';
            $result['report'] = Report::where('id', $report->id)->with(['company', 'user', 'branch'])->first();
        }
        return response()->json($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $result = [];
        try {
            $rep = Report::where('id',$id)->with(['user','company', 'branch'])->first();
            $walkInEntries = DB::table('report_types')
                                        ->where('report_id', '=', $id)
                                        ->where('type', '=', 'walk_in')
                                        ->get();
                                        
            $walkData = ReportType::where('report_id', $id)->where('type', 'walk_in')->with('fields')->get();
            // foreach($walkInEntries as $walk) {
            //     $ww = [];
            //     $ww['entry']
            // }                            
            $phoneInEntries = DB::table('report_types')
                                        ->where('report_id', '=', $id)
                                        ->where('type', '=', 'phone_in')
                                        ->get();  
            $other = DB::table('overallentries')
                                ->where('report_id', '=', $id)->get();                             
            $phoneData = ReportType::where('report_id', $id)->where('type', 'phone_in')->with('fields')->get();                                                     
            $report = ['report'=>$rep, 'walk_in_entries'=>$walkData, 'phone_in_entries'=> $phoneData, 'trend_entries'=>$other];
            $result['code'] = 0;
            $result['report'] = $report;
        } catch(Exception $e) {
            $result['code'] = 1;
            $result['message'] = "Server error";
        }
        return response()->json($result);
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
        $input = $request->all();
        $request->validate([
            'label'=> 'required',
            'company_id'=> 'required',
            'branch_id'=> 'required',
        ]);
        $reprot = Report::findOrFail($id);
        if($report->id !== Auth::user()->id) {
            return response()->json(['code'=> 1, 'message'=> 'You cannot edit this report because you are ']);
        }
        $report = Report::where('id', $id)->update([
            'label'=> $input['label'],
            'company_id'=> $input['company_id'],
            'branch_id'=> $input['branch_id'],
            'user_id'=> Auth::user()->id
        ]);
        $result = [];
        if($report) {
            $result['code'] = 0;
            $result['message']= 'report created successfully';
            $result['report'] = Report::where('id', $report)->with(['company', 'user', 'branch'])->first();
        }
        return response()->json($result);
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
        try{
            Report::destroy($id);
            $result['code'] = 0;
            $result['message'] = "report successfully deleted";
        } catch(Exception $e) {
            $result['code'] = 1;
            $result['message'] = "Server error! Please contact ernest";
        }
        return response()->json($result);
    }

    public function addRank(Request $request, $id)
    {
        $input = $request->all();
        $report = Report::findOrFail($id);
        if($input['title'] == "previous") {
            $report->previous_num = $input['num'];
            $report->previous_den = $input['den'];
        } else {
            $report->current_num = $input['num'];
            $report->current_den = $input['den'];
        }
        $report->update();
        $result=['code'=>0];
        return response()->json($result);
    }
}
