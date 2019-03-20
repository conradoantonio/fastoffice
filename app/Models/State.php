<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'states';
    
    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'abreviation', 'country'
	];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

	/**
     * Get the municipalities related with the model.
     */
    public function municipalities()
    {
        return $this->hasMany(Municipality::class, 'state_id', 'id');
    }

    /**
     * Get the branchs related with the model.
     */
    public function branchs()
    {
        return $this->hasMany(Branch::class);
    }
}
