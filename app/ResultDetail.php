<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResultDetail extends Model
{
    protected $table = 'results_details';

    protected $guarded = [];

    public $timestamps = false;

    public function fees()
    {
    	return $this->hasMany(ResultFee::class,'detail_id','id');
    }
}
