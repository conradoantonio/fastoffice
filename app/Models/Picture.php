<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
	protected $fillable = [
		'template_id', 'path', 'size'
	];

	public $timestamps = false;

	public function branch(){
		return $this->belongsTo(Branch::class, 'parent_id');
	}

	public function office(){
		return $this->belongsTo(Office::class, 'parent_id');
	}
}
