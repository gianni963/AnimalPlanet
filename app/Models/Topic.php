<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Thread;

class Topic extends Model
{
	public function getRouteKeyName()
	{
		return 'slug';
	}

	public function threads()
	{
		return $this->hasMany(Thread::class);
	}
   
}
