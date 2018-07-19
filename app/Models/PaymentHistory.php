<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payments_history';
    
    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'contract_id', 'payment', 'payment_str', 'type', 'payment_method', 'status',
	];

	/**
     * Get the contract associated with the application.
     */
    public function contract()
    {
        return $this->hasOne(User::class, 'id', 'contract_id');
    }
}
