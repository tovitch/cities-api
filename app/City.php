<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
	public function getRouteKeyName()
	{
		return 'name';
	}

	public function department()
	{
		return $this->belongsTo(Department::class);
    }
}
