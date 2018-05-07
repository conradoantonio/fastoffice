<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
	protected $fillable = [
		'branch_office_id', 'name', 'address'
	];

	public function branch_office(){

	}
}
