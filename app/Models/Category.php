<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
USE Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
	use SoftDeletes;

	public $timestamps = false;

	protected $fillable = [
		'name', 'status', 'type'
	];
}
