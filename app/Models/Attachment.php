<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
	protected $fillable = [
		'template_id', 'path', 'size'
	];

	public $timestamps = false;

	public function template(){
		return $this->belongsTo(Template::class);
	}
}
