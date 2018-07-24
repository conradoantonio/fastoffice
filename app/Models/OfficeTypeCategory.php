<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfficeTypeCategory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'office_type_categories';
    
    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'office_type_id', 'name', 'view_name',
	];
}
