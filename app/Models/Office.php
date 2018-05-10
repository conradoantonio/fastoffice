<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
USE Illuminate\Database\Eloquent\SoftDeletes;

class Office extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'branch_id', 'user_id', 'name', 'address', 'price', 'num_people'
	];

	public function user(){
		return $this->belongsTo(User::class);
	}

	public function branch(){
		return $this->belongsTo(Branch::class);
	}
}
