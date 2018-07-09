<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contracts';
    
    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'user_id', 'application_id', 'office_id', 'contract_date', 'provider_name', 'provider_ine_number', 'customer_ine_number', 'customer_activity', 
        'customer_address', 'start_date_validity', 'end_date_validity', 'monthly_payment_str', 'payment_range_start', 'payment_range_end', 'monthly_payment_delay_str',
	];

	/**
     * Get the possible application associated with the contract.
     */
    public function application()
    {
        return $this->hasOne(Application::class, 'id', 'application_id');
    }

	/**
     * Get the customer associated with the contract.
     */
    public function customer()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Get the office associated with the contract.
     */
    public function office()
    {
        return $this->hasOne(Office::class, 'id', 'office_id');
    }
}
