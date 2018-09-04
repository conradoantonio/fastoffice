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
		'user_id', 'application_id', 'office_id', 'contract_date', 'provider_name', 'provider_ine_number', 'customer_ine_number', 'customer_activity', 'customer_address', 
        'start_date_validity', 'end_date_validity', 'monthly_payment_str', 'payment_range_start', 'payment_range_end', 'monthly_payment_delay_str', 'status',
	];

	/**
     * Get the application associated with the contract.
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

    /**
     * Get the possible cancellation of the contract.
     */
    public function cancelation()
    {
        return $this->hasOne(CancelledContract::class, 'contract_id', 'id');
    }

    /**
     * Get the municipality of the provider notary.
     */
    public function customer_notary_state()
    {
        return $this->hasOne(State::class, 'id', 'customer_notary_state_id');
    }

    /**
     * Get the state of the provider notary.
     */
    public function provider_notary_state()
    {
        return $this->hasOne(State::class, 'id', 'provider_notary_state_id');
    }

    /**
     * Get the payments history from a contract.
     */
    public function payment_history()
    {
        return $this->hasMany(PaymentHistory::class, 'contract_id', 'id');
    }

    /**
     * Get the charges from a contract.
     */
    public function charges()
    {
        return $this->hasMany(ChargeContract::class, 'contract_id', 'id');
    }

    /**
     * Get the contracts filtered by the user rol.
     */
    static function filter_rows($l_usr, $app_status, $branch_id = null)
    {
        $contracts = Contract::whereHas('application', function($query) use($app_status) {
            $query->orderBy('id', 'desc')->where('status', $app_status);
        })->whereHas('office', function($que) use($l_usr, $branch_id) {
            if ($l_usr->role_id == 3) {//Recepcionista
                $que->where('user_id', $l_usr->id);
            }
            $que->whereHas('branch', function($q) use($l_usr, $branch_id) {
                if ($branch_id) {
                    $q->where('id', $branch_id);
                }
                if ($l_usr->role_id == 2) {//Franquiciatario
                    $q->where('user_id', $l_usr->id);
                }
            });
        })->get();

        return $contracts;
    }
}
