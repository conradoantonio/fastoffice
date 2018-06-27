<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfficePicture extends Model
{
	protected $fillable = [
		'office_id', 'path', 'size'
	];

	public $timestamps = false;

	public function office(){
		return $this->belongsTo(Office::class);
	}
}
