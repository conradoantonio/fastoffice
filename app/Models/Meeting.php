<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
	protected $fillable = [
		'user_id', 'office_id', 'title', 'description', 'datetime_start', 'datetime_end'
	];

	public function user(){
		return $this->belongsTo(User::class);
	}

	public function office(){
		return $this->belongsTo(Office::class);
	}
}
