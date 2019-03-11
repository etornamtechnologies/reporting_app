<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ReportType;
use App\OverallData;

class Report extends Model
{
    protected $fillable = ['label', 'company_id', 'branch_id', 'user_id'];

    public function report_types() {
        return $this->hasMany('App\ReportType');
    }

    public function overall_data()
    {
        return $this->hasMany('App\OverallData');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function company()
    {
        return $this->belongsTo('App\Company');
    }

    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }
}
