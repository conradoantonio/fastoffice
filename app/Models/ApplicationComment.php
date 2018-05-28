<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationComment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'applications_comments';
    
    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'application_id', 'comment'
	];

	/**
     * Get the application associated with the comment.
     */
    public function application()
    {
        return $this->hasOne(Application::class, 'id', 'application_id');
    }
}
