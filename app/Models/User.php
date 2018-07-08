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
		'fullname', 'email', 'password', 'phone', 'birthday', 'municipality_id', 'state_id', 'openpay_customer_id', 'player_id', 'role_id', 'branch_id', 'regime', 'rfc'
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

	public function role(){
		return $this->belongsTo(Role::class);
	}

	public function branch(){
		return $this->hasOne(Branch::class, 'user_id');
	}

	public function office(){
		return $this->hasOne(Office::class);
	}

	public function belongsBranch(){
		return $this->belongsTo(Branch::class, 'branch_id');
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

}
