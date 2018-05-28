<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'applications';
    
    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'user_id', 'fullname', 'email', 'phone', 'office_id', 'status', 'comment'
	];

	/**
     * Get the possible user associated with the application.
     */
    public function customer()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Get the possible user associated with the application.
     */
    public function detail()
    {
        return $this->hasOne(ApplicationDetail::class, 'application_id', 'id');
    }

    /**
     * Get the comments associated with the application.
     */
    public function comments()
    {
        return $this->hasMany(ApplicationComment::class, 'application_id', 'id');
    }

    /**
     * Get the office associated with the application.
     */
    public function office()
    {
        return $this->hasOne(Office::class, 'id', 'office_id');
    }
}
