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

    /**
     * Set the attributes to uppercase.
     *
     * @param  string  $value
     * @return void
     */
    public function __set($key, $value)
    {
        if ( array_key_exists($key, $this->fillable) ) {
        #if( in_array($key, ['fullname']) ){
            //do your mutation
            $this->setAttribute($key, mb_strtoupper($value, 'UTF-8'));
            #$this->attributes['fullname'] = mb_strtoupper($value, 'UTF-8');
        } else {
            //do what Laravel normally does
            $this->setAttribute($key, $value);
        }
    }
}
