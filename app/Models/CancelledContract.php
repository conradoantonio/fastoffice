<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CancelledContract extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cancelled_contracts';
    
    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'contract_id',
	];

	/**
     * Get the contract .
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}
