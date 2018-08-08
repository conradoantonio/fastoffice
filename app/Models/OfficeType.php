<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfficeType extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'office_types';
    
    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name'
	];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

	/**
     * Get the possible categories associated with the office.
     */
    public function category()
    {
        return $this->hasMany(OfficeTypeCategory::class, 'office_type_id', 'id');
    }
}
