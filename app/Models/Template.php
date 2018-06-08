<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
	protected $fillable = [
		'name', 'content'
	];

	public $timestamps = false;

	public function attachments(){
		return $this->hasMany(Attachment::class);
	}
}
