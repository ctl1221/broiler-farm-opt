<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Company extends Model
{
    protected $fillable = ['name'];

    public function active_contracts()
    {
    	return $this->hasMany(Contract::class)->where('date_valid', '>=', Carbon::now()->toDateString());
    }

    public function expired_contracts()
    {
    	return $this->hasMany(Contract::class)->where('date_valid', '<', Carbon::now()->toDateString());
    }
}
