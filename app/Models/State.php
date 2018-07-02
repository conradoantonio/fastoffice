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
     * Get the municipalities related with the state.
     */
    public function municipalities()
    {
        return $this->hasMany(Municipality::class, 'state_id', 'id');
    }
}
