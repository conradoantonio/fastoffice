<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuggestedPrice extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'suggested_prices';
    
    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'contract_id', 'user_id', 'office_id', 'new_price'
	];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['created_at', 'updated_at'];

	/**
     * Get the contract associated with the suggested price.
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    /**
     * Get the contract associated with the suggested price.
     */
    public function office()
    {
        return $this->belongsTo(Office::class)->withTrashed();
    }

    /**
     * Get the receptionist user associated with the suggested price.
     */
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
}
