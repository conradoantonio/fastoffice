<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchPicture extends Model
{
	protected $fillable = [
		'branch_id', 'path', 'size'
	];

	public $timestamps = false;

	public function branch(){
		return $this->belongsTo(Branch::class);
	}
}
