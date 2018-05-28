<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationDetail extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'applications_details';
    
    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'application_id', 'badget', 'num_people', 'office_type_id'
	];

	/**
     * Get the application asociated with the detail.
     */
    public function application()
    {
        return $this->hasOne(Application::class, 'id', 'application_id');
    }
}
