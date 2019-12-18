<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResultHeader extends Model
{
    protected $table = 'results_header';

    protected $guarded = [];

    public $timestamps = false;

    public function details()
    {
    	return $this->hasMany(ResultDetail::class,'header_id','id');
    }

    public function fees()
    {
    	return $this->hasManyThrough(ResultFee::class, ResultDetail::class, 'header_id','detail_id');
    }
}
