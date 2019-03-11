<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Report;

class OverallData extends Model
{
    protected $table = 'overallentries';

    protected $fillable = ['label', 'value', 'report_id'];

    public function report()
    {
        return $this->belongsTo('App\Report', 'report_id');
    }
}
