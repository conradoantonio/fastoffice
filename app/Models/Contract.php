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
		'user_id', 'application_id', 'office_id', 'state_id', 'municipality_id', 'country', 'contract_date', 'start_date_validity', 'end_date_validity', 'bank_reference', 'usage', 'additional_people', 'meeting_room_hours', 
        'telephone_line', 'computer_station', 'monthly_payment_str', 'monthly_payment_delay_str', 'actual_pay_date', 'balance', 'balance_str', 'payment_range_start', 'payment_range_end', 'status', 'office_type_category_id', 
        'start_hour', 'end_hour', 'total_hours', 'provider_name', 'provider_rfc', 'customer_rfc', 'customer_email', 'customer_phone', 'customer_identification_type', 'customer_identification_num', 'customer_business_activity', 
        'customer_address' 
	];

	/**
     * Get the application associated with the contract.
     */
    public function application()
    {
        return $this->belongsTo(Application::class);
        #return $this->hasOne(Application::class, 'id', 'application_id');
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
        return $this->belongsTo(Office::class);
    }

    /**
     * Get the state associated with the contract.
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    /**
     * Get the municipality associated with the contract.
     */
    public function municipality()
    {
        return $this->belongsTo(Municipality::class);
    }

    /**
     * Get the office type category associated with the contract (only virtual offices).
     */
    public function office_type_category()
    {
        return $this->belongsTo(OfficeTypeCategory::class);
    }
    

    /**
     * Get the possible cancellation of the contract.
     */
    public function cancelation()
    {
        return $this->hasOne(CancelledContract::class, 'contract_id', 'id');
    }

    /**
     * Get the possible suggested price of the office's contract.
     */
    public function suggested_price()
    {
        return $this->hasOne(SuggestedPrice::class, 'contract_id', 'id');
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
     * Set the user's first name.
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

    /**
     * Get the contracts filtered by the user rol.
     */
    static function filter_rows($l_usr, $app_status, $branch_id = null)
    {
        $contracts = Contract::whereHas('application', function($query) use($app_status) {
            $query->orderBy('id', 'desc')->where('status', $app_status);
        })->whereHas('office', function($que) use($l_usr, $branch_id) {
            if ($l_usr->role_id == 3) {//Recepcionista
                //$que->where('user_id', $l_usr->id);
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
