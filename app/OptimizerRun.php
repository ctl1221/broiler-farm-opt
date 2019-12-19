<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ResultHeader;

class OptimizerRun extends Model
{
    protected $guarded = [];

    public function original()
    {
    	return $this->hasOne(ResultHeader::class, 'run_id','id')
    	->with('details','fees')
    	->where('optimized',0);
    }

    public function top_k($k)
    {
    	return ResultHeader::with('details','fees')
    						->where('run_id', $this->id)
    						->where('optimized',1)
    						->orderBy('income','desc')
    						->limit($k)
    						->get();
    }
}
