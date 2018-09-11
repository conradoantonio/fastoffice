<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SendHistoryTemplate extends Model
{
	protected $fillable = [
		'prospect_id', 'template_id'
	];

	public function prospect(){
		return $this->belongsTo(Application::class, 'prospect_id');
	}

	public function template(){
		return $this->belongsTo(Template::class);
	}
}
