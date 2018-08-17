<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notifications';
    
    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'user_id', 'origin', 'title', 'content', 'status'
	];

	/**
     * Get the user associated with the notification.
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
