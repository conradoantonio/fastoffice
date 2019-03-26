<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
USE Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
	use Notifiable;
	use SoftDeletes;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'branch_id', 'fullname', 'email', 'password', 'phone', 'rfc', 'address', 'business_activity', 
		'identification_type', 'identification_num', 'photo', 'role_id', 'player_id', 'social', 'status'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	protected $dates = [
		'deleted_at'
	];

	public function checkRole($roles){
		foreach ($roles as $role) {
			if ($this->role->name == $role) {
				return true;
			}
		}
		return false;
	}

	/**
     * Get the contracts of cutomer.
     */
	public function contracts()
	{
		return $this->hasMany(Contract::class, 'user_id', 'id');
	}

	public function role(){
		return $this->belongsTo(Role::class);
	}

	public function branches(){
		return $this->hasMany(Branch::class, 'user_id');
	}

	public function office(){
		return $this->hasOne(Office::class);
	}

	public function belongsBranch(){
		return $this->belongsTo(Branch::class, 'branch_id', 'id');
	}

	public function calendars(){
		return $this->hasMany(Calendar::class);
	}

	static public function totalUsersByRole($role = null){
		if ( $role ){
			return User::where('role_id',$role)->count();
		}
		return User::count();
	}

	/**
     * Set the user's first name.
     *
     * @param  string  $value
     * @return void
     */
	/*public function __set($name, $value) 
	{
	    if (array_key_exists($name, $this->fillable) {
	        $this->attributes[$name] = !empty($value) ? $value : 0;
	    }
	}*/


	/**
     * Set the user's first name.
     *
     * @param  string  $value
     * @return void
     */
    /*public function setFullnameAttribute($value)
    {
        $this->attributes['fullname'] = mb_strtoupper($value, 'UTF-8');
    }*/

    /**
     * Set the user's first name.
     *
     * @param  string  $value
     * @return void
     */
    public function __set($key, $value)
	{
		dd($key);
	    if( in_array($key, ['fullname']) ){
	        //do your mutation
	        $this->setAttribute($key, mb_strtoupper($value, 'UTF-8'));
        	#$this->attributes['fullname'] = mb_strtoupper($value, 'UTF-8');
	    } else {
	        //do what Laravel normally does
	        $this->setAttribute($key, $value);
	    }
	}

}
