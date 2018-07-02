<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'municipalities';
    
    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'num_head', 'municipal_head', 'state_id'
	];

	/**
     * Get the state associated with the municipality.
     */
    public function state()
    {
        return $this->belongsTo(State::class, 'id', 'state_id');
    }
}
