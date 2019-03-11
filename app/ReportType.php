<?php

namespace App;
use App\ReportField;

use Illuminate\Database\Eloquent\Model;

class ReportType extends Model
{
    protected $fillable = ['report_id', 'type', 'label'];

    public function fields() 
    {
        return $this->hasMany('App\ReportField', 'report_type_id');
    }
}
