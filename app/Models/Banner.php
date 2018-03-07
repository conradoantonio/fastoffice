<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
	protected $fillable = [
		"image"
	];

	protected $hidden = [
		'created_at', 'updated_at'
	];
}
