<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
USE Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'user_id', 'name', 'address', 'status'
	];

	public function users(){
		return $this->hasMany(User::class);
	}

	public function offices(){
		return $this->hasMany(Office::class);
	}
}
