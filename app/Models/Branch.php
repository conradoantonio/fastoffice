<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
USE Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'user_id', 'state_id', 'municipality_id', 'name', 'address', 'colony', 'zip_code', 'phone', 'website', 'description', 'status'
	];

	public function state(){
		return $this->belongsTo(State::class);
	}

	public function municipality(){
		return $this->belongsTo(Municipality::class);
	}

	public function user(){
		return $this->belongsTo(User::class);
	}

	public function users(){
		return $this->hasMany(User::class);
	}

	public function offices(){
		return $this->hasMany(Office::class);
	}

	public function pictures(){
		return $this->hasMany(BranchPicture::class);
	}
}
