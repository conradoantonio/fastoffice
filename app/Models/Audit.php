<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
	public $timestamps = false;

	protected $fillable = [
		'branch_id', 'user_id', 'tittle', 'status'
	];

	public function auditDetail(){
		return $this->hasMany(AuditDetail::class);
	}

	public function branch(){
		return $this->belongsTo(Branch::class);
	}

	public function user(){
		return $this->belongsTo(User::class);
	}
}
