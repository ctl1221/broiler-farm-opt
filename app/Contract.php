<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
	protected $fillable = ['name','company_id','date_valid'];
}
