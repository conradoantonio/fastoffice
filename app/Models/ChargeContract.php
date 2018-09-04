<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChargeContract extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'charges_contracts';
    
    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'contract_id', 'amount', 'amount_str', 'pay_date', 'status'
	];

	/**
     * Get the contract associated with the contract.
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}
