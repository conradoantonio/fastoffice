<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
	protected $fillable = [
		'user_id', 'start_datetime', 'office_id', 'description'
	];

	public function user(){
		return $this->belongsTo(User::class);
	}

	public function office(){
		return $this->belongsTo(Office::class);
	}
}
