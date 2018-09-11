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

    /**
     * Get the send history template associated with the application.
     */
    public function SendHistoryTemplate()
    {
        return $this->hasOne(SendHistoryTemplate::class, 'prospect_id', 'id');
    }

    /**
     * Get the applications filtered by the user rol.
     */
    static function filter_rows($l_usr, $app_status, $branch_id = null)
    {
        $applications = Application::whereHas('office', function($que) use($l_usr, $branch_id) {
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
        })
        ->orderBy('id', 'desc')->where('status', $app_status)
        ->get();

        return $applications;
    }
}
