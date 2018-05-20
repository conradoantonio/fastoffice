<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Erp extends Model
{
	protected $fillable = [
		'category_id', 'office_id', 'concept', 'amount', 'type'
	];

	public function office(){
		return $this->belongsTo(Office::class);
	}
}
