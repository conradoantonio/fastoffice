<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
USE Illuminate\Database\Eloquent\SoftDeletes;

class Office extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'branch_id', 'user_id', 'office_type_id', 'name', 'address', 'price', 'num_people'
	];

	public function type(){
		return $this->hasOne(OfficeType::class, 'id', 'office_type_id');
	}

	public function user(){
		return $this->belongsTo(User::class);
	}

	public function branch(){
		return $this->belongsTo(Branch::class);
	}
}
