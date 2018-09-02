<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
	public $timestamps = false;

	protected $fillable = [
		'office_id', 'user_id', 'tittle', 'status'
	];

	public function auditDetail(){
		return $this->hasMany(AuditDetail::class);
	}

	public function office(){
		return $this->belongsTo(Office::class);
	}

	public function user(){
		return $this->belongsTo(User::class);
	}
}
