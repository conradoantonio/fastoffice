<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
	protected $fillable = [
		"name", "description", "philosophy", "privacy", "terms_conditions", "picture",
	];

	protected $hidden = [
		'created_at', 'updated_at'
	];
}
