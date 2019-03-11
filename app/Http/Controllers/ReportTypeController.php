<?php

namespace App\Http\Controllers;
use App\Report;
use App\ReportType;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ReportTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function createReportType(Request $request, $reportId)
    {
        $input = $request->all();
        $result = [];
        try {
            $reportType = ReportType::create([
                'report_id'=> $reportId,
                'label'=> $input['label'],
                'type'=>$input['type']
            ]);
            $result = [];
            $result['code']=0;
            $result['report'] = $reportType;
        } catch(Exception $e) {
            $result['code'] = 1;
            $result['message'] = "Server error";
        }
        return response()->json($result);
    }

    public function deleteReportType($id) 
    {
        $result = [];
        try {
            ReportType::destroy($id);
            $result = ['code'=> 0];
        } catch(Exception $e) {
            $result['code'] = 1;
            $result['message'] = "Server error"; 
        }
        return response()->json($result);
    }
}
