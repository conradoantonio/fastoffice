<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
	public $timestamps = false;

	protected $fillable = [
		'office_id', 'user_id', 'tittle'
	];

	public function auditDetail(){
		return $this->hasMany(AuditDetail::class);
	}
}
