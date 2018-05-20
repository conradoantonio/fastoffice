<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Erp extends Model
{
	protected $fillable = [
		'category_id', 'concept', 'amount', 'type'
	];
}
