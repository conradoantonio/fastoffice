<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
	protected $fillable = [
		''
	];

	public function offices(){
		return $this->hasMany(Office::class);
	}
}
