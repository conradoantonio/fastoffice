<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Erp extends Model
{
	protected $fillable = [
		'category_id', 'office_id', 'branch_id', 'concept', 'amount', 'type', 'file', 'date'
	];

	public function office(){
		return $this->belongsTo(Office::class);
	}

	public function branch(){
		return $this->belongsTo(Branch::class);
	}

	public function category(){
		return $this->belongsTo(Category::class)->withTrashed();
	}
}
