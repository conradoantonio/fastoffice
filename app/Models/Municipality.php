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
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['num_head', 'municipal_head', 'created_at', 'updated_at'];

	/**
     * Get the state associated with the municipality.
     */
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    /**
     * Get the branchs related with the model.
     */
    public function branchs()
    {
        return $this->hasMany(Branch::class);
    }
}
