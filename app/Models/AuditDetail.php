<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditDetail extends Model
{
	public $timestamps = false;

	protected $fillable = [
		'question_id', 'answer', 'detail'
	];

	public function audit(){
		return $this->belongsTo(Audit::class);
	}

	public function question(){
		return $this->belongsTo(Question::class);
	}

	public function answer(){
		return $this->belongsTo(Answer::class);
	}

	public function photos(){
		return $this->hasMany(AuditPhoto::class);
	}
}
