<?php

namespace App\Observers;

use App\Models\Meeting;

class MeetingObserver
{
	/**
	 * Listen to the Meeting created event.
	 *
	 * @param  \App\Meeting  $meeting
	 * @return void
	 */
	public function saved(Meeting $meeting)
	{
		if ( auth()->check() && auth()->user()->role_id == 3 ){
			session()->forget('reminders');
			$today = date('Y-m-d');
			$meetings = Meeting::with(['office', 'user'])
				->where('datetime_start', '>=', $today.' 00:00:00')
				->where('datetime_start', '<=', $today.' 23:59:59')
				->where('status', '1')
				->whereHas('office', function($q){
					$q->where('branch_id', auth()->user()->branch_id);
				})->get();
			session(['reminders' => $meetings]);
		}
	}

	/**
	 * Listen to the Meeting deleting event.
	 *
	 * @param  \App\Meeting  $meeting
	 * @return void
	 */
	public function deleted(Meeting $meeting)
	{
		if ( auth()->check() && auth()->user()->role_id == 3 ){
			session()->forget('reminders');
			$today = date('Y-m-d');
			$meetings = Meeting::with(['office', 'user'])
				->where('datetime_start', '>=', $today.' 00:00:00')
				->where('datetime_start', '<=', $today.' 23:59:59')
				->where('status', '1')
				->whereHas('office', function($q){
					$q->where('branch_id', auth()->user()->branch_id);
				})->get();
			session(['reminders' => $meetings]);
		}
	}
}