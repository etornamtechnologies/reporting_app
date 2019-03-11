<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ReportType;

class ReportField extends Model
{
    protected $fillable = ['report_type_id', 'label', 'numerator', 'denumerator', 'approve'];

    public function report_type()
    {
        return $this->belongsTo('App\ReportType');
    }
}
