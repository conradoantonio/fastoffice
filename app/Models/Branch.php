<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
USE Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'user_id', 'name', 'address', 'phone', 'website', 'zip_code', 'locality', 'description', 'status'
	];

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
		return $this->hasMany(Picture::class, 'parent_id');
	}
}
