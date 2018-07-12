<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditPhoto extends Model
{
	public $timestamps = false;

	protected $fillable = [
		'audit_id', 'path'
	];

	public function auditdetail(){
		return $this->belongsTo(AuditDetail::class);
	}
}
