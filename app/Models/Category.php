<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
	use SoftDeletes;

	public $timestamps = false;

	protected $fillable = [
		'branch_id', 'name', 'status', 'type'
	];

    /**
     * Get the possible franchise associated with the record.
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

	/**
     * Get the categories filtered by user.
     */
    static function filter_rows($l_usr, $type = null)
    {
    	$rows = Category::query();

    	#Role Admin
    	if ( $l_usr->role->id == 1 ) {
    		$rows = $rows;
    	} 
    	#Franchise
    	else if ( $l_usr->role->id == 2 ) {
            $rows = $rows->where(function ($query) use ($l_usr) {
                $query->where('branch_id', 0)
                ->orWhereIn('branch_id', $l_usr->branches->pluck('id'));
            });
    		#$rows = $rows->where('branch_id', 0)->orWhereIn('branch_id', $l_usr->branches->pluck('id'));
    	}
    	#Recepcionist
    	else if ( $l_usr->role->id == 3 ) {
    		#$rows = $rows->where('branch_id', 0)->orWhere('branch_id', $l_usr->branch_id);
            $rows = $rows->where(function ($query) use ($l_usr) {
                $query->where('branch_id', 0)
                ->orWhere('branch_id', $l_usr->branch_id);
            });
    	}

        #Filter by ingress(1) or expenses(2)
        if ( $type ) {
            $rows = $rows->where('type', $type);
        }

    	$rows = $rows->get();
    	/*$rows = $rows->toSql();

    	dd($rows);*/

        return $rows;
    }
}
