<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OverallData;

class OverallDataController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function createData(Request $request, $id)
    {
        $input = $request->all();
        $request->validate([
            'label'=>'required',
            'value'=>'required'
        ]);
        $trend = OverallData::create([
            'report_id'=> $id,
            'label'=> $input['label'],
            'value'=> $input['value']
        ]);
        $result = ['code'=> 0, 'trend'=> $trend];
        return response()->json($result);
    }

    public function deleteData($id) {
        OverallData::destroy($id);
        $result = ['code'=> 0];
        return response()->json($result);
    }
}
