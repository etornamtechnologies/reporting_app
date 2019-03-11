<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = 'branches';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
