<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OptimizerRun extends Model
{
    protected $guarded = [];

    public function original()
    {
    	return $this->hasOne(ResultHeader::class, 'run_id','id')->where('optimized',0);
    }
}
